<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Branch;
use App\Models\User;
use App\Models\BranchPicture;
use Image;
use Excel;

class BranchesController extends Controller
{
	public function index(Request $req){
		$branches = Branch::with('user')->get();
		if ( $req->ajax() ) {
			return view('branches.table', compact('branches'));
		}
		return view('branches.index', compact('branches'));
	}

	public function form($id = null){
		$branch = new Branch();
		$users = User::where(['role_id' => 2, 'status' => 1])->pluck('fullname', 'id')->prepend("Seleccione un usuario", 0);
		$child_users = User::doesntHave('belongsBranch')->where(['role_id' => 3, 'status' => 1])->pluck('fullname', 'id');

		if ( $id ) {
			$branch = Branch::findOrFail($id);

			$child_users = User::where(['role_id' => 3, 'status' => 1])->where(function($query) use($id){
				$query->where('branch_id', 0);
				$query->orWhere('branch_id', $id);
			})->pluck('fullname', 'id');
		}
		return view('branches.form', compact('branch', 'users', 'child_users'));
	}

	public function store(Request $req){
		$photo = $req->file('photo');

		$branch = new Branch();
		$branch->fill($req->except('child_user_ids'));

		if ( $branch->save() ){
			if ( $req->child_user_ids ){
				User::whereIn('id', $req->child_user_ids)->update(['branch_id' => $branch->id]);
			}
			File::makeDirectory(public_path()."/img/branches/".$branch->id, 0777, true, true);

			return Redirect()->route('Branch')->with('msg', 'Franquicia creada');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear franquicia');
		}
	}

	public function update(Request $req, $id){
		$branch = Branch::find($id);
		$branch->fill($req->except('photo', 'child_user_ids'));

		if ( $req->child_user_ids ){
			User::where('branch_id', $branch->id)->update(['branch_id' => 0]);
			User::whereIn('id', $req->child_user_ids)->update(['branch_id' => $branch->id]);
		}

		if ( $req->hasFile('photo') ){
			$directorio = public_path()."/img/branches/".$branch->id.'/';
			if (!File::exists($directorio)){
				File::makeDirectory($directorio, 0777, true, true);
			}

			$image = $req->file('photo');
			$name = date("His").$branch->pictures->count().'.'.$image->getClientOriginalExtension();
			$path = $directorio.$name;

			if ( $image ) {
				$picture = new BranchPicture();
				$picture->path = '/img/branches/'.$id.'/'.$name;
				$picture->size = $image->getClientSize();
				$branch->pictures()->save($picture);

				Image::make($image)->save($path);
			}
			return;
		}

		if ( $branch->save() ){
			return Redirect()->route('Branch')->with('msg', 'Franquicia actualizada');
		} else {
			return Redirect()->back()->with('msg', 'Error al actualizar franquicia');
		}
	}

	public function destroy($id){
		if ( Branch::destroy($id) ) {
			#File::deleteDirectory(public_path()."/img/branches/".$id."/");
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function multipleDestroys(Request $req){
		if ( Branch::destroy($req->ids) ){
			/*foreach ($req->ids as $id) {
				File::deleteDirectory(public_path()."/img/branches/".$id."/");
			}*/
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
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
					$branch = Branch::firstOrCreate(
						['name' => $value->store_code, 'address' => $value->address_line_1.' '.$value->sub_locality, 'phone' => $value->primary_phone],
						[
							'name' => $value->store_code,
							'address' => $value->address_line_1.' '.$value->sub_locality,
							'phone' => $value->primary_phone,
							'website' => $value->website,
							'zip_code' => $value->postal_code,
							'locality' => $value->locality
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

	public function status(Request $req){
		$branch = Branch::find($req->id);
		$branch->status = $branch->status?'0':'1';
		if ( $branch->save() ) {
			return ['status' => true];
		} else {
			return ['status' => false];
		}
	}

	public function deleteBranchPicture(Request $req){
		$branchPicture = BranchPicture::where('path', $req->path)->first();
		if ( $branchPicture->delete() ){
			File::delete(public_path().$req->path);
			return ['status' => true, 'msg' => 'Imagen eliminado'];
		}
		return ['status' => false, 'msg' => 'Imagen eliminado'];
	}
}
