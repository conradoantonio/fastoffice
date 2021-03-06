<?php

namespace App\Http\Controllers;

use Image;
use Excel;
use App\Models\User;
use App\Models\State;
use App\Models\Branch;
use App\Models\Office;
use App\Models\Municipality;
use App\Models\BranchPicture;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
		if ( auth()->user()->role->name == "Recepcionista" ) { return view('errors.503'); }
		$branch = new Branch();
		$users = User::where(['role_id' => 2, 'status' => 1])->pluck('fullname', 'id')->prepend("Seleccione un usuario", 0);
		$child_users = User::doesntHave('belongsBranch')->where(['role_id' => 3, 'status' => 1])->pluck('fullname', 'id');

		$states = State::pluck('name', 'id')->prepend('Selecciona un estado', 0);
		$municipalities = [0 => 'Seleccione un municipio'];

		if ( $id ) {
			$branch = Branch::findOrFail($id);
			if ( $branch->user ){
				$users->prepend($branch->user->fullname, $branch->user->id)->forget(0)->prepend("Seleccione un usuario", 0);
			}

			if ( $branch ) {
				$municipalities = Municipality::whereHas('state', function($query) use ($branch) {
					$query->where('id', $branch->state_id);
				})->pluck('name', 'id')->prepend('Seleccione una ciudad', 0);
			}

			$child_users = User::where(['role_id' => 3, 'status' => 1])->where(function($query) use($id) {
				$query->where('branch_id', 0);
				$query->orWhere('branch_id', $id);
			})->pluck('fullname', 'id');
		}
		return view('branches.form', compact('branch', 'users', 'child_users', 'states', 'municipalities'));
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

	public function update(Request $req, $id)
	{
		$branch = Branch::find($id);
		$branch->fill($req->except('photo', 'child_user_ids'));

		#Detach any receptionist from the franchise, then validate if we need to add another recepcionist
		User::where('branch_id', $branch->id)->update(['branch_id' => 0]);

		if ( $req->child_user_ids ){
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
		$branch = Branch::find($id);
		if ( $branch ) {
			$user_recepcionist = User::where('branch_id', $branch->id)->pluck('id');
			$offices = $branch->offices->pluck('id');
			//User::destroy($branch->user_id);
			$recepcionists = User::find($user_recepcionist);

			#Lets detach branch from recepcinist
			if (count($recepcionists)) {
				foreach ($recepcionists as $recepc) {
					$recepc->branch_id = 0;
					$recepc->save();
				}
			}
			foreach ($offices as $of_id) {
				Office::destroy($of_id);
			}
			Branch::destroy($id);
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function multipleDestroys(Request $req){
		$recepcionists = User::whereIn('branch_id', $req->ids)->get();
		$branches = Branch::whereIn('id', $req->ids)->get();
		if ( $branches ){
			$branches->each(function($branch, $key){
				if ( $branch->office ){
					$branch->office->each(function($office, $key){
						Office::destroy($office->id);
					});
				}
			});

			#Lets detach branch from recepcinist
			if (count($recepcionists)) {
				foreach ($recepcionists as $recepc) {
					$recepc->branch_id = 0;
					$recepc->save();
				}
			}
			#User::destroy($branch->user_id);
			#User::destroy($users_ids);
			Branch::destroy($req->ids);
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
