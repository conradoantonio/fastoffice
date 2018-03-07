<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BannerRequest;
use Illuminate\Support\Facades\File;
use App\Models\Banner;
use Redirect;
use Image;

class BannersController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req)
	{
		$banners = Banner::all();
		if ( $req->ajax() ) {
			return view('banners.table', compact('banners'));
		}
		return view('banners.index', compact('banners'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function form($id = null)
	{
		$banner = new Banner();
		if ( $id ){
			$banner = Banner::find($id);
		}
		return view('banners.form', compact('banner'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $req
	 * @return \Illuminate\Http\Response
	 */
	public function store(BannerRequest $req)
	{
		$image = $req->file('image');

		$banner = new Banner();
		$banner->image = time().'.'.$image->getClientOriginalExtension();

		if ( $banner->save() ){
			File::makeDirectory(public_path()."/img/banners/".$banner->id, 0777, true, true);
			$path = public_path()."/img/banners/".$banner->id."/".$banner->image;
			Image::make($image)->save($path);

			return Redirect()->route('Banner')->with('msg', 'Banner creado');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear banner');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $req
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(BannerRequest $req, $id)
	{
		$image = $req->file('image');

		$banner = Banner::find($id);

		if ( $image ){
			File::cleanDirectory(public_path()."/img/banners/".$banner->id."/");
			$banner->image = time().'.'.$image->getClientOriginalExtension();
			$path = public_path()."/img/banners/".$banner->id."/".$banner->image;
			Image::make($image)->save($path);
		}

		if ( $banner->save() ){
			return Redirect()->route('Banner')->with('msg', 'Banner actualizado');
		} else {
			return Redirect()->back()->with('msg', 'Error al actualizar banner');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if ( Banner::destroy($id) ) {
			File::deleteDirectory(public_path()."/img/banners/".$id."/");
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function multipleDestroys(BannerRequest $req){
		if ( Banner::destroy($req->ids) ){
			foreach ($req->ids as $id) {
				File::deleteDirectory(public_path()."/img/banners/".$id."/");
			}
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
	}

	public function status($id){
		$banner = Banner::find($id);
		$banner->status = $banner->status?0:1;
		if ( $banner->save() ) {
			return ['status' => true];
		} else {
			return ['status' => false];
		}
	}
}
