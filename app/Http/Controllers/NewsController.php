<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewRequest;
use Illuminate\Support\Facades\File;
use App\Models\News;
use Redirect;
use Image;

class NewsController extends Controller
{
	public function index(Request $req){
		$news = News::all();
		if ( $req->ajax() ) {
			return view('news.table', compact('news'));
		}
		return view('news.index', compact('news'));
	}

	public function form($id = null){
		$new = new News();
		if ( $id ) {
			$new = News::findOrFail($id);
		}
		return view('news.form', compact('new'));
	}

	public function store(NewRequest $req){
		$photo = $req->file('photo');

		$new = new News();

		$new->title = $req->title;
		$new->content = $req->content;
		$new->photo = time().'.'.$photo->getClientOriginalExtension();

		if ( $new->save() ){
			File::makeDirectory(public_path()."/img/news/".$new->id, 0777, true, true);
			$path = public_path()."/img/news/".$new->id."/".$new->photo;
			Image::make($photo)->fit(261,213)->save($path);

			return Redirect()->route('News')->with('msg', 'Noticia creada');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}

	public function update(NewRequest $req, $id){
		$photo = $req->file('photo');

		$new = News::find($id);
		$new->title = $req->title;
		$new->content = $req->content;

		if ( $photo ){
			File::cleanDirectory(public_path()."/img/news/".$new->id."/");
			$new->photo = time().'.'.$photo->getClientOriginalExtension();
			$path = public_path()."/img/news/".$new->id."/".$new->photo;
			Image::make($photo)->fit(261,213)->save($path);
		}

		if ( $new->save() ){
			return Redirect()->route('News')->with('msg', 'Noticia actualizada');
		} else {
			return Redirect()->back()->with('msg', 'Error al actualizar noticia');
		}
	}

	public function destroy($id){
		if ( News::destroy($id) ) {
			File::deleteDirectory(public_path()."/img/news/".$id."/");
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function multipleDestroys(NewRequest $req){
		if ( News::destroy($req->ids) ){
			foreach ($req->ids as $id) {
				File::deleteDirectory(public_path()."/img/news/".$id."/");
			}
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
	}

	public function status(Request $req){
		$new = News::find($req->id);
		$new->status = $new->status?'0':'1';
		if ( $new->save() ) {
			return ['status' => true];
		} else {
			return ['status' => false];
		}
	}
}
