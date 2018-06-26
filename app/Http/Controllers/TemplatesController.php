<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Template;
use App\Models\Attachment;
use Image;

class TemplatesController extends Controller
{
	public function index(Request $req){
		$templates = Template::all();
		if ( $req->ajax() ){
			return view('templates.table', compact('templates'));
		}
		return view('templates.index', compact('templates'));
	}

	public function form($id = null){
		$template = new Template();
		if ( $id ){
			$template = Template::find($id);
		}
		return view('templates.form', compact('template'));
	}

	public function store(Request $req){
		$template = new Template();
		$template->fill($req->all());

		if ( $template->save() ){
			return redirect()->route('Template')->with('msg', 'Plantilla creada');
		} else {
			return redirect()->back()->with('msg', 'Error al crear plantilla');
		}
	}

	public function update(Request $req, $id){
		$template = Template::find($id);
		$template->fill($req->except('file'));

		if ( $req->hasFile('file') ){
			$directorio = public_path().'/img/templates/'.$req->id.'/';
			if (!File::exists($directorio)){
				File::makeDirectory($directorio, 0777, true, true);
			}
			$image = $req->file('file');
			$name = date("His").'.'.$image->getClientOriginalExtension();
			$path = $directorio.$name;

			if ( $image ) {
				$attachment = new Attachment();
				$attachment->path = '/img/templates/'.$id.'/'.$name;
				$attachment->size = $image->getClientSize();
				$template->attachments()->save($attachment);

				Image::make($image)->save($path);
			}
			return;
		}

		if ( $template->save() ){
			return redirect()->route('Template')->with('msg', 'Plantilla actualizada');
		} else {
			return redirect()->back()->with('msg', 'Error al actualizar plantilla');
		}
	}

	public function destroy($id){
		if ( Template::destroy($id) ){
			File::deleteDirectory(public_path()."/img/templates/".$id."/");
			return ["delete" => "true"];
		}
		return ["delete" => "false"];
	}

	public function multipleDestroys(Request $req){
		if ( Template::destroy($req->ids) ){
			foreach ($req->ids as $id) {
				File::deleteDirectory(public_path()."/img/templates/".$id."/");
			}
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
	}

	public function status(Request $req){
		$faq = Template::find($req->id);
		$faq->status = $faq->status?0:1;

		if ( $faq->save() ) {
			return ["status" => true];
		}
		return ["status" => false];
	}
}
