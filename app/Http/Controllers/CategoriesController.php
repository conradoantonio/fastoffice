<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Branch;

class CategoriesController extends Controller
{
	public function index(Request $req){
		$categories = Category::filter_rows(auth()->user());
		if ( $req->ajax() ){
			return view('categories.table', compact('categories'))->render();
		}
		return view('categories.index', compact('categories'))->render();
	}

	public function form($id = null){
		$category = new Category();
		$branches = Branch::pluck('name', 'id')->prepend("Cualquiera", 0);
		if ( $id ) {
			$category = Category::findOrFail($id);
		}
		return view('categories.form', compact('category', 'branches'));
	}

	public function store(Request $req){
		$category = new Category();
		$category->fill($req->all());

		if ( $category->save() ){
			return redirect()->route('Category')->with('msg', 'Categoría creada');
		} else {
			return redirect()->back()->with('msg', 'Error al crear Categoría');
		}
	}

	public function update(Request $req, $id){
		$category = Category::find($id);
		$category->fill($req->all());

		if ( $category->save() ){
			return redirect()->route('Category')->with('msg', 'Categoría actualizada');
		} else {
			return redirect()->back()->with('msg', 'Error al actualizar Categoría');
		}
	}

	public function destroy($id){
		if ( Category::destroy($id) ){
			return ["delete" => "true"];
		}
		return ["delete" => "false"];
	}

	public function multipleDestroys(Request $req){
		if ( Category::destroy($req->ids) ){
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
	}

	public function status(Request $req){
		$category = Category::find($req->id);
		$category->status = $category->status?0:1;

		if ( $category->save() ) {
			return ["status" => true];
		}
		return ["status" => false];
	}
}
