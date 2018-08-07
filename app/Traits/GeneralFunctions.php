<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

use App\Models\OfficeTypeCategory;
use App\Models\Application;
use App\Models\Contract;
use App\Models\Office;
use App\Models\User;

use Mail;
use Image;

trait GeneralFunctions
{
	/*
	* Descrición: Función para enviar correo electrónico;
	* Parametros: arreglo params (view: vista del email, email: correo destino, subjet: asunto del correo, title: titulo dentro del correo, content: cuerpo del correo, etc)
	* return boolean, true exito al enviar correo, false error al enviar correo
	*/
	public function mail($params)
	{
		$params['view'] = @$params['view']?$params['view']:'mails.general';
		Mail::send($params['view'], ['title' => $params['title'], 'content' => $params['content']], function ($message) use($params)
		{
			$message->to($params['email']);
			$message->from(env('MAIL_USERNAME'), env('APP_NAME'));
			$message->subject(env('APP_NAME').' | '.$params['subject']);
		});
		if ( !Mail::failures() ){
			error_log('enviado');
			return true;
		}
		error_log('error_send: '.Mail::failures());
		return false;
	}

	/**
     * Check if is necessary to create an application user.
     *
     * @return \Illuminate\Http\Response
     */
	public function create_user($prospect_id)
	{
		$row = Application::find($prospect_id);

		if (!$row) { return false; }//Application not found

		$user = User::find($row->user_id);

		if (!$user) {//If the application row has not an user assigned
			$exist_us = User::where('email', $row->email)->first();

			if ($exist_us) {//Use an existing user

				$row->user_id = $exist_us->id;

			} else {//Create new user
				$u_app = New User;

				$u_app->fullname = $row->fullname; 
				$u_app->email = $row->email;
				$u_app->password = bcrypt($row->email);
				$u_app->phone = $row->phone;
				$u_app->regime = $row->regime;
				$u_app->rfc = $row->rfc;
				$u_app->role_id = 4;

				$u_app->save();

				$row->user_id = $u_app->id;//Update the application row with the created user
			}

			//Updates the application row
			$row->fullname = null;
            $row->email = null;
            $row->phone = null;
            $row->regime = null;
            $row->rfc = null;

            $row->save();

			return true;
		}

		return false;
	}

	/**
     * Check if an office is available.
     *
     * @return \Illuminate\Http\Response
     */
	public function check_office_status($office_id)
	{
		$available = Office::where('status', 1)->where('id', $office_id)->first();

		return $available ? true : false;
	}

	/**
     * Change the office status.
     *
     * @return \Illuminate\Http\Response
     */
	public function change_office_status($office_id, $status)
	{
		Office::where('id', $office_id)
        ->update(['status' => $status]);
	}

	/**
     * Creates the view path for contracts.
     *
     * @return \Illuminate\Http\Response
     */
	public function get_contract_path(Contract $contract)
	{
		$folder = $subfolder = $view = $path = '';
		//First folder
		if ($contract->office->branch->user->regime == 'Persona física') { $folder = 'physical_person'; } 
		if ($contract->office->branch->user->regime == 'Persona moral') { $folder = 'moral_person'; } 

		//Subfolder
		if ($contract->office->type->name == 'Física') { $subfolder = 'physical_office'; } 
		
		//Special code for virtual offices
		if ($contract->office->type->name == 'Virtual') { 
			$subfolder = 'virtual_office';
	        $aux = OfficeTypeCategory::find($contract->office_type_category_id);
	        if ($aux) {
				$subfolder = $subfolder.'.'.$aux->view_name;
	        }
		}
		if ($contract->office->type->name == 'Sala de juntas') { $subfolder = 'meeting_room'; } 
		if ($contract->office->type->name == 'Sala de conferencias') { $subfolder = 'conference_room'; } 

		//Contract view
		if ($contract->customer->regime == 'Persona física') { $view = 'physical_person'; } 
		if ($contract->customer->regime == 'Persona moral') { $view = 'moral_person'; } 

		if ($folder && $subfolder && $view) {//Got all params
			$path = 'contracts'.'.'.$folder.'.'.$subfolder.'.'.$view;
			return $path;
		}

		return false;
	}

	/**
     * Check if a path exist, if don't, create it.
     *
     * @return \Illuminate\Http\Response
     */
	public function make_path($path) 
	{
		if (!File::exists($path)) {
            File::makeDirectory(public_path($path), 0755, true, true);
        }
    }

    /**
     * Send a notification to a single user or a group of users.
     *
     * @return $name
     */
    public function send_notification($type, $app_id, $app_key, $app_icon, $title, $content, $date, $time, $data, $users_id)
    {
        $player_ids = array();
        
        $header = array(
            "en" => $title
        );

        $msg = array(
            "en" => $content
        );
        
        $fields = array(
            'app_id' => $app_id,
            'data' => $data,
            'headings' => $header,
            'contents' => $msg,
            'large_icon' => $app_icon
        );

        if ($type == 1) {//General notification
            $fields['included_segments'] = array('All');
        } 

        else if ($type == 2) {//Individual notification
            foreach($users_id as $id) {
                $user = User::find($id);
                $player_ids [] = $user->player_id;
            }
            $fields['include_player_ids'] = $player_ids;
        }

        if ($date && $time) {
            $time_zone = $date.' '.$time;
            $time_zone = $this->summer ? $time_zone.' '.'UTC-0500' : $time_zone.' '.'UTC-0600';
            $fields['send_after'] = $time_zone;
        }

        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   "Authorization: Basic $app_key"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        foreach ($users_id as $id) {
            $user = User::find($id);

            $not = New Notification;

            $not->user_id = $user ? $user->id : 0; 
			$not->origin = $data['origin'];
			$not->title = $title;
			$not->content = $content;

			$not->save();
        }

        return $response;
    }
}