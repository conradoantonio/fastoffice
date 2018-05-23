<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ErpRequest;
use App\Models\Erp;
use App\Models\Office;
use App\Models\Branch;
use App\Models\Category;

class ErpController extends Controller
{
	public function index(Request $req, $id = null){
		$earnings = Erp::where('type', 1)->whereHas('office', function($q) use($id){
			if ( auth()->user()->role_id == 2 ){
				$q->where('branch_id', auth()->user()->branch->id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		})->get();
		$expenses = Erp::where('type', 2)->whereHas('office', function($q) use($id){
			if ( auth()->user()->role_id == 2 ){
				$q->where('branch_id', auth()->user()->branch->id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		})->get();

		$branches = Branch::pluck('name', 'id')->prepend("Seleccione una franquicia",0);

		if ($req->ajax()) {
			return view('erp.content', compact('earnings', 'expenses'));
		}
		return view('erp.index', compact('earnings', 'expenses', 'branches'));
	}

	public function form($type, $id = null){
		$erp = new Erp();
		$offices = Office::where('status', 1)->pluck('name','id')->prepend("Seleccione una oficina", 0);
		$categories = [0 => 'Seleccione una categoría'];

		if ( $id ) {
			$erp = Erp::findOrFail($id);
			$categories = Category::where('type', $erp->type_id)->get();
		}
		return view('erp.form', compact('erp', 'offices', 'categories'));
	}

	public function store(ErpRequest $req){
		$erp = new Erp();
		$erp->fill($req->all());

		if ( $erp->save() ){
			return Redirect()->route('Erp')->with('msg', 'Registro creado');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}

	public function update(ErpRequest $req, $id){
		$erp = Erp::find($id);
		$erp->fill($req->all());

		if ( $erp->save() ){
			return Redirect()->route('Erp')->with('msg', 'Registro actualizado');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}

	public function destroy($id){
		if ( Erp::destroy($id) ) {
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function getCategoriesByType($type_id){
		return Category::where(['type' => $type_id])->get();
	}
}
