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
			$template->user_status_id  = $template->user_status_id + 1;
		}
		return view('templates.form', compact('template'));
	}

	public function store(Request $req){
		$template = new Template();
		$template->fill($req->except('user_status_id', 'type_id'));
		$template->type_id  = !$req->type_id?1:$req->type_id;
		$template->user_status_id  = $req->user_status_id - 1;

		if ( $template->save() ){
			return redirect()->route('Template')->with('msg', 'Plantilla creada');
		} else {
			return redirect()->back()->with('msg', 'Error al crear plantilla');
		}
	}

	public function update(Request $req, $id){
		$aux = 0;
		$template = Template::find($id);
		$template->fill($req->except(['file', 'user_status_id', 'type_id']));
		$template->type_id  = !$req->type_id?1:$req->type_id;
		$template->user_status_id  = $req->user_status_id - 1;

		if ( $req->hasFile('file') ){
			$directorio = public_path().'/img/templates/'.$req->id.'/';
			if (!File::exists($directorio)){
				File::makeDirectory($directorio, 0777, true, true);
			}
			$image = $req->file('file');
			$name = date("His");
			$last = Attachment::orderBy('id', 'desc')->first();
			if ($last) { $aux = $last->id; }
			$name = $name.$aux.'.'.$image->getClientOriginalExtension();
			$path = $directorio.$name;

			if ( $image ) {
				$attachment = new Attachment();
				$attachment->path = '/img/templates/'.$id.'/'.$name;
				$attachment->size = $image->getClientSize();
				$template->attachments()->save($attachment);

				if ( strtolower($image->getClientOriginalExtension()) == 'pdf'){
					$image->move($directorio, $name);
				} else {
					Image::make($image)->save($path);
				}
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
			if ( File::deleteDirectory(public_path()."/img/templates/".$id."/") ){

			}
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
