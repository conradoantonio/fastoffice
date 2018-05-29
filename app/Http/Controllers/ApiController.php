<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\Application;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Save a new application and validates if is a registered user.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_prospect(Request $req)
    {
        $user = User::find($req->user_id);
        $office = Office::find($req->office_id);

        if (!$office) {
            return response(['msg' => 'Esta oficina no se encuentra disponible, seleccione otra', 'status' => 'error', 'refresh' => 'none'], 400);
        }

        $row = New Application;

    	if ($user) {//Comes from a registered user
    		$row->user_id = $user->id;
    	} else {
            $row->fullname = $req->fullname;
            $row->email = $req->email;
            $row->phone = $req->phone;
        }

        $row->office_id = $office->id;

        $row->save();

        return response(['msg' => 'Prospecto registrado correctamente', 'status' => 'success', 'url' => url('crm/prospectos')], 200);
    }
}
