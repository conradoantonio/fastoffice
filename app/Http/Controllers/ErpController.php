<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ErpRequest;
use App\Models\Erp;
use App\Models\Office;
use App\Models\Category;

class ErpController extends Controller
{
	public function index(Request $req){
		$earnings = Erp::where('type', 1)->get();
		$expenses = Erp::where('type', 2)->get();

		if ($req->ajax()) {
			return view('erp.content', compact('earnings', 'expenses'));
		}
		return view('erp.index', compact('earnings', 'expenses'));
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
