<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OfficeRequest;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\Branch;
use Image;

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
		$photo = $req->file('photo');

		$office = new Office();
		$office->fill($req->except('photo'));
		$office->photo = time().'.'.$photo->getClientOriginalExtension();

		if ( $office->save() ){
			File::makeDirectory(public_path()."/img/offices/".$office->id, 0777, true, true);
			$path = public_path()."/img/offices/".$office->id."/".$office->photo;
			Image::make($photo)->save($path);

			return Redirect()->route('Office')->with('msg', 'Oficina creada');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear oficina');
		}
	}

	public function update(OfficeRequest $req, $id){
		$photo = $req->file('photo');

		$office = Office::find($id);
		$office->fill($req->except('photo'));

		if ( $photo ){
			File::cleanDirectory(public_path()."/img/offices/".$office->id."/");
			$office->photo = time().'.'.$photo->getClientOriginalExtension();
			$path = public_path()."/img/offices/".$office->id."/".$office->photo;
			Image::make($photo)->save($path);
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

	public function getUsersByBranch($branch_id){
		return User::where(['role_id' => 3, 'status' => 1, 'branch_id' => $branch_id])->get();
	}
}
