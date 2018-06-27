<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OfficeRequest;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\Branch;
use App\Models\OfficePicture;
use Image;
use Excel;

class OfficesController extends Controller
{
	public function index(Request $req, $id = null){
		$offices = Office::with('type', 'branch', 'user')->whereHas('branch', function($q) use($id){
			if ( auth()->user()->role_id == 2 ){
				$q->where('branch_id', auth()->user()->branch->id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		})->get();

		$branches = Branch::pluck('name', 'id')->prepend('Mostrar todas', 0);
		if ( $req->ajax() ) {
			return view('offices.table', compact('offices'));
		}
		return view('offices.index', compact('offices', 'branches'));
	}

	public function form($id = null){
		$office = new Office();
		$types = OfficeType::pluck('name', 'id')->prepend("Seleccione un tipo", 0);
		$users = [0 => "Seleccione un usuario"];
		$offices = Branch::where('status', 1)->pluck('name','id')->prepend("Seleccione una sucursal", 0);

		if ( $id ) {
			$office = Office::findOrFail($id);
			$users = User::where(['role_id' => 3, 'branch_id' => $office->branch_id])->pluck('fullname', 'id')->prepend("Seleccione un usuario", 0);
		}
		return view('offices.form', compact('office', 'users', 'offices', 'types'));
	}

	public function store(OfficeRequest $req){
		$office = new Office();
		$office->fill($req->except('photo'));

		if ( $office->save() ){
			File::makeDirectory(public_path()."/img/offices/".$office->id, 0777, true, true);

			return Redirect()->route('Office')->with('msg', 'Oficina creada');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear oficina');
		}
	}

	public function update(OfficeRequest $req, $id){
		$office = Office::find($id);
		$office->fill($req->except('photo'));

		if ( $req->hasFile('photo') ){
			$directorio = public_path()."/img/offices/".$office->id."/";
			if (!File::exists($directorio)){
				File::makeDirectory($directorio, 0777, true, true);
			}

			$image = $req->file('photo');
			$name = date("His").$office->pictures->count().'.'.$image->getClientOriginalExtension();
			$path = $directorio.$name;

			if ( $image ) {
				$picture = new OfficePicture();
				$picture->path = '/img/offices/'.$id.'/'.$name;
				$picture->size = $image->getClientSize();
				$office->pictures()->save($picture);

				Image::make($image)->save($path);
			}
			return;
		}

		if ( $office->save() ){
			return Redirect()->route('Office')->with('msg', 'Oficina actualizada');
		} else {
			return Redirect()->back()->with('msg', 'Error al actualizar oficina');
		}
	}

	public function destroy($id){
		if ( Office::destroy($id) ) {
			#File::deleteDirectory(public_path()."/img/offices/".$id."/");
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function multipleDestroys(Request $req){
		if ( Office::destroy($req->ids) ){
			/*foreach ($req->ids as $id) {
				File::deleteDirectory(public_path()."/img/offices/".$id."/");
			}*/
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
	}

	public function status(Request $req){
		$office = Office::find($req->id);
		$office->status = $office->status?'0':'1';
		if ( $office->save() ) {
			return ['status' => true];
		} else {
			return ['status' => false];
		}
	}

	public function import(Request $req){
		if ($req->hasFile('archivo-excel')) {
			$path = $req->file('archivo-excel')->getRealPath();
			$extension = $req->file('archivo-excel')->getClientOriginalExtension();

			$data = Excel::load($path, function($reader) {
				$reader->setDateFormat('Y-m-d');
			})->get();


			if (!empty($data) && $data->count()) {
				foreach ($data as $value) {
					$branch = Branch::where('name', $value->sucursal)->first();
					$type = 0;
					if ( $value->type == 'Física' ){
						$type = 1;
					} elseif ( $value->type == 'Virtual' ){
						$type = 2;
					} elseif ( $value->type == 'Sala de juntas' ){
						$type = 3;
					} else {
						$type = 4;
					}

					$office = Office::firstOrCreate(
						['name' => $value->name, 'address' => $value->address, 'phone' => $value->phone],
						[
							'branch_id' => $branch?$branch->id:0,
							'name' => $value->name,
							'address' => $value->address,
							'phone' => $value->phone,
							'price' => $value->price,
							'num_people' => $value->people,
							'office_type_id' => $type,
							'description' => $value->description
						]
					);
				}
			} else {
				return ['status' => false, 'msg' => 'El excel esta vació'];
			}
			return ['status' => true, 'msg' => 'Se han importado los regitros del excel'];
		}
		else {
			return ['status' => false, 'msg' => "Ocurrió un problema para leer el excel"];
		}
	}

	public function getUsersByBranch($branch_id){
		return User::where(['role_id' => 3, 'status' => 1, 'branch_id' => $branch_id])->get();
	}

	public function getPicturesByOffice($id){
		$office = Office::find($id);
		return $office->pictures;
	}

	public function deleteOfficePicture(Request $req){
		$officePicture = OfficePicture::where('path', $req->path)->first();
		if ( $officePicture->delete() ){
			File::delete(public_path().$req->path);
			return ['status' => true, 'msg' => 'Imagen eliminado'];
		}
		return ['status' => false, 'msg' => 'Imagen eliminado'];
	}
}
