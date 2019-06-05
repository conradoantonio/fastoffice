<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OfficeRequest;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\State;
use App\Models\Branch;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\OfficePicture;
use App\Models\Municipality;

use Image;
use Excel;

class OfficesController extends Controller
{
	public function index(Request $req, $id = null){
		$offices = Office::with('type', 'branch', 'user')->whereHas('branch', function($q) use($id) {
			#Rol Franquiciatario
			if ( auth()->user()->role_id == 2 ) {
				$q->whereIn('branch_id', auth()->user()->branches->pluck('id'));
			} else {
				if ( $id ) {
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
		if ( auth()->user()->role_id == 1 ){//Admin
			$offices = Branch::where('status', 1)->pluck('name','id')->prepend("Seleccione una sucursal", 0);
		} else {
			$offices = Branch::where('user_id', auth()->user()->id)->where('status', 1)->pluck('name','id')->prepend("Seleccione una sucursal", 0);
		}

		if ( $id ) {
			$office = Office::findOrFail($id);
			$users = User::where(['role_id' => 3, 'branch_id' => $office->branch_id])->pluck('fullname', 'id')->prepend("Seleccione un usuario", 0);
			
		}
		return view('offices.form', compact('office', 'users', 'offices', 'types'));
	}

	public function store(OfficeRequest $req){
		$office = new Office();
		$office->fill($req->except('photo'));
		$office->monthly_price = round( $req->price * .90, PHP_ROUND_HALF_UP, 2 );

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
		$office->monthly_price = round( $req->price * .90, PHP_ROUND_HALF_UP, 2 );
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
		$office = Office::find($id);
		if ( Office::destroy($id) ) {
			User::destroy($office->user_id);
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function multipleDestroys(Request $req){
		$users_ids = Office::whereIn('id', $req->ids)->pluck('user_id');
		if ( Office::destroy($req->ids) ){
			User::destroy($users_ids);
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

	public function import(Request $req)
	{
		if ($req->hasFile('archivo-excel')) {
			$path = $req->file('archivo-excel')->getRealPath();
			$extension = $req->file('archivo-excel')->getClientOriginalExtension();

			$data = Excel::load($path, function($reader) {
				$reader->setDateFormat('Y-m-d');
			})->get();


			if (!empty($data) && $data->count()) {
				foreach ($data as $value) {
					$branch = Branch::where('name', $value->franchise)->first();
					$type = OfficeType::where('name', $value->type)->first();
					
					if (! $branch ) continue ;#If branch is not defined...
					if (! $value->name ) continue ;#If name is not defined...
					if (! $value->price ) continue ;#If price is not defined...
					if (! $value->phone ) continue ;#If phone is not defined...
					if (! $value->people ) continue ;#If people is not defined...
					
					$state = State::where('name', $value->state)->first();
					$municipality = Municipality::where('name', $value->municipality)->first();

					$office = Office::updateOrCreate(
						['branch_id' => $branch->id, 'name' => $value->name, 'phone' => $value->phone],
						[
							'branch_id' => $branch ? $branch->id : 0,
							'state_id' => $state ? $state->id : 0,
							'municipality_id' => $municipality ? $municipality->id : 0,
							'name' => $value->name,
							'num_int' => $value->num_int,
							'phone' => $value->phone,
							'price' => $value->price,
							'monthly_price' => round( $value->price * .90, PHP_ROUND_HALF_UP, 2 ),
							'num_people' => $value->people,
							'office_type_id' => $type ? $type->id : 1,
							'description' => $value->description
						]
					);
				}
			} else {
				return ['status' => false, 'msg' => 'El excel esta vacío'];
			}
			return ['status' => true, 'msg' => 'Se han importado los registros del excel'];
		}
		else {
			return ['status' => false, 'msg' => "Ocurrió un problema para leer el excel, contacte al administrador"];
		}
	}

	public function getUsersByBranch($branch_id){
		return User::doesntHave('office')->where(['role_id' => 3, 'status' => 1, 'branch_id' => $branch_id])->get();
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

	public function getMunicipalities($state_id){
		return Municipality::whereHas('state', function($query) use ($state_id){
			$query->where('id', $state_id);
		})
		->select('name', 'id')->get();
	}
}
