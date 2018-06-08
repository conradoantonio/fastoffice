<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attachment;
use Image;

class AttachmentsController extends Controller
{
	public function delete(Request $req){
		$attachment = Attachment::where('path', $req->path)->first();
		if ( $attachment->delete() ){
			return ['status' => true, 'msg' => 'Archivo adjunto eliminado'];
		}
		return ['status' => false, 'msg' => 'Archivo adjunto eliminado'];
	}
}
