<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use redirect;

class FaqsController extends Controller
{
	public function index(Request $req){
		$faqs = Faq::all();
		if ( $req->ajax() ){
			return view('faqs.table', compact('faqs'));
		}
		return view('faqs.index', compact('faqs'));
	}

	public function form($id = null){
		$faq = new Faq();
		if ( $id ) {
			$faq = Faq::findOrFail($id);
		}
		return view('faqs.form', compact('faq'));
	}

	public function store(FaqRequest $req){
		$faq = new Faq();
		$faq->fill($req->all());

		if ( $faq->save() ){
			return redirect()->route('Faq')->with('msg', 'Faq creada');
		} else {
			return redirect()->back()->with('msg', 'Error al crear faq');
		}
	}

	public function update(FaqRequest $req, $id){
		$faq = Faq::find($id);
		$faq->fill($req->all());

		if ( $faq->save() ){
			return redirect()->route('Faq')->with('msg', 'Faq actualizada');
		} else {
			return redirect()->back()->with('msg', 'Error al actualizar faq');
		}
	}

	public function destroy($id){
		if ( Faq::destroy($id) ){
			return ["delete" => "true"];
		}
		return ["delete" => "false"];
	}

	public function multipleDestroys(FaqRequest $req){
		if ( Faq::destroy($req->ids) ){
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
	}

	public function status($id){
		$faq = Faq::find($id);
		$faq->status = $faq->status?0:1;

		if ( $faq->save() ) {
			return ["status" => true];
		}
		return ["status" => false];
	}
}
