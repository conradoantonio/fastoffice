<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Erp;
use App\Models\Office;

class ErpController extends Controller
{
	public function index(Request $req){
		$earnings = Erp::where('type', 1)->get();
		$expenses = Erp::where('type', 2)->get();
		return view('erp.index', compact('earnings', 'expenses'));
	}

	public function form($type, $id = null){
		$erp = new Erp();
		$offices = Office::where('status', 1)->pluck('name','id')->prepend("Seleccione una oficina", 0);

		if ( $id ) {
			$erp = Erp::findOrFail($id);
		}
		return view('erp.form', compact('erp', 'offices'));
	}

	public function store(ErpRequest $req){
		$erp = new Erp();
		$erp->fill($req->all());

		if ( $erp->save() ){
			return Redirect()->route('ERP')->with('msg', 'Registro creado');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}

	public function update(ErpRequest $req, $id){
		$erp = Erp::find($id);
		$erp->fill($req->all());

		if ( $erp->save() ){
			return Redirect()->route('ERP')->with('msg', 'Registro actualizado');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}
}
