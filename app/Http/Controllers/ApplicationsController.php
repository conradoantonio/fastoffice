<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Office;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    /**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {
        $title = "Prospectos";
        $menu = "CRM";
        $prospects = Application::orderBy('id', 'desc')->where('status', 0)->get();

        if ($req->ajax()) {
            return view('applications.prospects.table', ['prospects' => $prospects]);
        }
        return view('applications.prospects.index', ['prospects' => $prospects, 'menu' => $menu , 'title' => $title]);
    }

    /**
     * Show the form for creating/editing a resource about a new prospect.
     *
     * @return \Illuminate\Http\Response
     */
    public function form_prospect($id = 0)
    {
        $title = "Formulario";
        $menu = "Prospectos";
        $prospect = null;
        $customers = User::where('role_id', 4)->get();
        $offices = Office::where('status', 1)->get();//Falta filtrar por disponibilidad y tipo de usuario
        if ($id) {
            $prospect = Application::where('status', 0)->first($id);
        }
        return view('applications.prospects.form', ['prospect' => $prospect, 'customers' => $customers, 'offices' => $offices, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Save a new prospect.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_prospect(Request $req)
    {
        return app('App\Http\Controllers\ApiController')->save_prospect($req);
    }

    /**
     * Change the status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_status(Request $req)
    {
        $msg = count($req->ids) > 1 ? 'los prospectos' : 'el prospecto';
        $prospects = Application::whereIn('id', $req->ids)
        ->update(['comment' => $req->comment,'status' => $req->status]);

        if ($prospects) {
            return response(['url' => url('crm/prospectos'), 'refresh' => 'table', 'status' => 'success' ,'msg' => 'Éxito cambiando el status de '.$msg], 200);
        } else {
            return response(['msg' => 'Error al cambiar el status de '.$msg, 'status' => 'error', 'url' => url('crm/prospectos')], 404);
        }
    }

    /**
     * Save an application comment
     *
     * @return \Illuminate\Http\Response
     */
    public function save_application_comments(Request $req)
    {
        $row = New ApplicationComment;

        $row->application_id = $req->application_id;
        $row->comment = $req->comment;

        $row->save();

        return response(['refresh' => 'none', 'status' => 'success', 'msg' => 'Comentario guardado'], 200);
    }

    /**
     * Look for offices that cumply the customer requirements
     *
     * @return \Illuminate\Http\Response
     */
    public function filter_offices(Request $req)
    {
        return Office::all();
    }
}
