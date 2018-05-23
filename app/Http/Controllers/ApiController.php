<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Save a new application and validates if is a registered user.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_application(Request $req)
    {
    	$user = User::find($req->user_id);

        $row = New Application;

    	if ($user) {//Comes from a registered user
    		
    	}

        $row->name = $req->name;
        $row->price = $req->price;
        $row->category_id = $req->category_id;
        $row->description = $req->description;

        $row->save();

        return response(['msg' => 'Producto registrado correctamente', 'status' => 'success', 'url' => url('admin/productos')], 200);
    }
}
