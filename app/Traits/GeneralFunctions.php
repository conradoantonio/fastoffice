<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

use App\Models\Application;
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
}