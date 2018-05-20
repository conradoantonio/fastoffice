<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Branch;
use App\Models\User;
use Image;

class BranchesController extends Controller
{
	public function index(Request $req){
		$branches = Branch::all();
		if ( $req->ajax() ) {
			return view('branches.table', compact('branches'));
		}
		return view('branches.index', compact('branches'));
	}

	public function form($id = null){
		$branch = new Branch();
		$users = User::doesntHave('hasBranch')->where(['role_id' => 2, 'status' => 1])->pluck('fullname', 'id')->prepend("Seleccione un usuario", 0);
		$child_users = User::doesntHave('belongsBranch')->where(['role_id' => 3, 'status' => 1])->pluck('fullname', 'id');

		if ( $id ) {
			$branch = Branch::findOrFail($id);
			$users = User::where(['role_id' => 2, 'status' => 1])->where(function($query) use($id){
				$query->where('branch_id', 0);
				$query->orWhere('branch_id', $id);
			})->pluck('fullname', 'id')->prepend("Seleccione un usuario", 0);

			$child_users = User::where(['role_id' => 3, 'status' => 1])->where(function($query) use($id){
				$query->where('branch_id', 0);
				$query->orWhere('branch_id', $id);
			})->pluck('fullname', 'id');
		}
		return view('branches.form', compact('branch', 'users', 'child_users'));
	}

	public function store(Request $req){
		#$photo = $req->file('photo');

		$branch = new Branch();
		$branch->fill($req->except('photo', 'child_user_ids'));
		#$branch->photo = time().'.'.$photo->getClientOriginalExtension();

		if ( $branch->save() ){
			if ( $req->child_user_ids ){
				User::whereIn('id', $req->child_user_ids)->update(['branch_id' => $branch->id]);
			}
			/*File::makeDirectory(public_path()."/img/branches/".$branch->id, 0777, true, true);
			$path = public_path()."/img/branches/".$branch->id."/".$branch->photo;
			Image::make($photo)->save($path);*/

			return Redirect()->route('Branch')->with('msg', 'Franquicia creada');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear franquicia');
		}
	}

	public function update(Request $req, $id){
		#$photo = $req->file('photo');

		$branch = Branch::find($id);
		$branch->fill($req->except('photo', 'child_user_ids'));

		User::where('branch_id', $branch->id)->update(['branch_id' => 0]);
		if ( $req->child_user_ids ){
			User::whereIn('id', $req->child_user_ids)->update(['branch_id' => $branch->id]);
		}

		/*if ( $photo ){
			File::cleanDirectory(public_path()."/img/branches/".$branch->id."/");
			$branch->photo = time().'.'.$photo->getClientOriginalExtension();
			$path = public_path()."/img/branches/".$branch->id."/".$branch->photo;
			Image::make($photo)->save($path);
		}*/

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

	public function status(Request $req){
		$branch = Branch::find($req->id);
		$branch->status = $branch->status?'0':'1';
		if ( $branch->save() ) {
			return ['status' => true];
		} else {
			return ['status' => false];
		}
	}
}