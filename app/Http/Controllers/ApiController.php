<?php

namespace App\Http\Controllers;
use Mail;

use App\Models\User;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\Application;
use App\Models\ApplicationDetail;

use App\Traits\GeneralFunctions;

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

        $prospect = New Application;

    	if ($user) {//Comes from a registered user
    		$prospect->user_id = $user->id;
    	} else {
            $prospect->fullname = $req->fullname;
            $prospect->email = $req->email;
            $prospect->phone = $req->phone;
            $prospect->regime = $req->regime;
            $prospect->rfc = $req->rfc;
        }

        $prospect->office_id = $office->id;

        $prospect->save();

        #Details
        $detail = New ApplicationDetail;

        $detail->application_id = $prospect->id;
        $detail->badget = $req->badget;
        $detail->num_people = $req->num_people;
        $detail->office_type_id = $office->type->id;

        $detail->save();

        return response(['msg' => 'Prospecto registrado correctamente', 'status' => 'success', 'url' => url('crm/prospectos')], 200);
    }

    /**
     * Look for offices that cumply the customer requirements
     *
     * @return \Illuminate\Http\Response
     */
    public function filter_offices(Request $req)
    {
        return app('App\Http\Controllers\ApplicationsController')->filter_offices($req);
    }
    

    /**
     * Send mails for schedule task.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEmailCronJob(Request $req)
    {
        $params = array();
        $params['subject'] = $req->subject;
        $params['title'] = $req->title;
        $params['content'] = $req->content;
        $params['reminders'] = $req->reminders;
        $params['email'] = $req->email;

        Mail::send('mails.reminder', ['title' => $params['title'], 'content' => $params['content'], 'reminders' => $params['reminders']], function ($mail) use ($params) {
            $mail->to($params['email'])
                ->from(env('MAIL_USERNAME'), env('APP_NAME'))
                ->subject(env('APP_NAME').' | '.$params['subject']);
        });
    }
}
