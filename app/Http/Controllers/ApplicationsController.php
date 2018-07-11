<?php

namespace App\Http\Controllers;

use PDF;

use App\Models\User;
use App\Models\Office;
use App\Models\Meeting;
use App\Models\Contract;
use App\Models\OfficeType;
use App\Models\Application;
use App\Models\ApplicationComment;
use App\Models\ApplicationDetail;

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
     * Show the rejected applications.
     *
     */
    public function show_applications_rejected(Request $req)
    {
        $title = "Prospectos (Rechazados)";
        $menu = "CRM";
        $prospects = Application::orderBy('id', 'desc')->where('status', 3)->get();

        if ($req->ajax()) {
            return view('applications.rejected.table', ['prospects' => $prospects]);
        }
        return view('applications.rejected.index', ['prospects' => $prospects, 'menu' => $menu , 'title' => $title]);
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
        $officeTypes = OfficeType::all();
        $offices = Office::where('status', 1)->get();//Falta filtrar por disponibilidad y tipo (privilegio) de usuario de sistema
        if ($id) {
            $prospect = Application::where('status', 0)->where('id', $id)->first();
            if ($prospect) {
                $offices = Office::where('id', $prospect->office->id)->where('status', 1)->get();
            }
        }
        return view('applications.prospects.form', ['prospect' => $prospect, 'customers' => $customers, 'offices' => $offices, 'officeTypes' => $officeTypes, 'menu' => $menu, 'title' => $title]);
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
     * Update a prospect.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_prospect(Request $req)
    {
        $prospect = Application::find($req->id);
        $user = User::find($req->user_id);
        $office = Office::find($req->office_id);

        if (!$prospect) {
            return response(['msg' => 'Prospecto inválido, refresque esta página', 'status' => 'error', 'refresh' => 'none'], 500);
        }

        if (!$office) {
            return response(['msg' => 'Esta oficina no se encuentra disponible, seleccione otra', 'status' => 'error', 'refresh' => 'none'], 400);
        }

        if ($user) {//Comes from a registered user
            $prospect->user_id = $user->id;
            $prospect->fullname = null;
            $prospect->email = null;
            $prospect->phone = null;
            $prospect->regime = null;
            $prospect->rfc = null;
        } else {
            $prospect->user_id = 0;
            $prospect->fullname = $req->fullname;
            $prospect->email = $req->email;
            $prospect->phone = $req->phone;
            $prospect->regime = $req->regime;
            $prospect->rfc = $req->rfc;
        }

        $prospect->office_id = $office->id;

        $prospect->save();

        #Details
        $detail = ApplicationDetail::find($prospect->detail->id);

        if ($detail) {
            $detail->badget = $req->badget;
            $detail->num_people = $req->num_people;
            $detail->office_type_id = $office->type->id;

            $detail->save();
        }

        return response(['msg' => 'Prospecto actualizado correctamente', 'status' => 'success', 'url' => url('crm/prospectos')], 200);
    }

    /**
     * Change the status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_status(Request $req)
    {
        $prospect = Application::where('id', $req->application_id)
        ->update(['comment' => $req->comment, 'status' => $req->status]);

        if ($prospect) {
            return response(['url' => url('crm/prospectos'), 'refresh' => 'table', 'status' => 'success' ,'msg' => 'Éxito cambiando el status del registro'], 200);
        } else {
            return response(['msg' => 'Error al cambiar el status del registro', 'status' => 'error', 'url' => url('crm/prospectos')], 404);
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

        if ($req->has('add_to_calendar')) {
            $met = New Meeting;

            $met->office_id = $row->application->office_id;
            $met->title = 'Comentario';
            $met->description = $req->comment;
            $met->datetime_start = date("Y-m-d H:i:s", strtotime($req->date.' '.$req->hour));
            $met->datetime_end = date("Y-m-d H:i:s", strtotime("+1 hours", strtotime($met->datetime_start)));

            $met->save();
        }

        return response(['refresh' => 'none', 'status' => 'success', 'msg' => 'Comentario guardado'], 200);
    }

    /**
     * View the comments from an application
     *
     * @return \Illuminate\Http\Response
     */
    public function view_applications_coments(Request $req)
    {
        return ApplicationComment::where('application_id', $req->id)->get();
    }

    /**
     * Get all the info from an application
     *
     * @return \Illuminate\Http\Response
     */
    public function get_application_info(Request $req)
    {
        $application = Application::find($req->id);
        $application->customer;
        $application->detail->office->type;
        $application->comments;
        return $application;
    }

    /**
     * Look for offices that cumply the customer requirements
     *
     * @return \Illuminate\Http\Response
     */
    public function filter_offices(Request $req)
    {
        $query = Office::query();

        if ($req->badget) { $query = $query->where('price', '<=', $req->badget); }

        if ($req->num_people) { $query = $query->where('num_people', '>=', $req->num_people); }

        if ($req->office_type_id) { 
            $query = $query->whereHas('type', function($q) use($req) {
                $q->where('id', $req->office_type_id);
            }); 
        }

        #Add filter to search only available offices
        //$query = $query->where('status', 1);

        return $query->get();
    }
}
