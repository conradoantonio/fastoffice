<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

use App\Models\User;
use App\Models\Audit;
use App\Models\State;
use App\Models\Office;
use App\Models\Meeting;
use App\Models\Question;
use App\Models\Contract;
use App\Models\AuditPhoto;
use App\Models\OfficeType;
use App\Models\AuditDetail;
use App\Models\Application;
use App\Models\Notification;
use App\Models\QuestionCategory;
use App\Models\ApplicationDetail;

use App\Http\Requests\UserRequest;
use App\Http\Requests\MeetingRequest;

use Image;
use Mail;

class ApiController extends Controller
{
	/**
	 * Webservice para loguearse dentro de la aplicación
	 *
	 * @return Datos del usuario
	 */
	public function login(Request $req)
	{
		$user = User::where('email','=',$req->email)->first();
		if ( $user ){
			if ( !$user->status ){
				return response([ 'msg' => 'Usuario inhabilitado.', 'code' => 0], 200);
			}
			if ( $user->role_id == 4 || $user->role_id == 5 ) {
				if (password_verify($req->password, $user['password'])) {
					$user->role;
					return response([ 'Usuario' => $user->setHidden(['password', 'branch_id', 'social', 'created_at', 'updated_at', 'deleted_at', 'remember_token']), 'code' => 1], 200);
				} else {
					return response([ 'msg'=>'La contraseña es incorrecta.', 'code' => 0], 200);
				}
			} else {
				return response([ 'msg' => 'Solo los usuarios de la aplicación y auditores pueden acceder.', 'code' => 0], 200);
			}
		} else{
			return [ 'msg'=>'No hay ningun usuario registrado con este correo.', 'code' => 0];
		}
	}

		/**
	 * Webservice para registrar un usuario en la app
	 *
	 * @return Arreglo con el usuario creado
	 */
	public function register(UserRequest $req)
	{
		$user = User::where('email','=',$req->email)->first();
		if ( !$user ){
			$user = new User();
			$user->fullname = $req->fullname;
			$user->email = $req->email;
			$user->role_id = 4;
			$user->player_id = $req->player_id;
			$password = trim($req->password);
			$user->phone = $req->phone;
			$user->password = bcrypt(trim($req->password));
			$user->photo = '/img/profiles/default.png';

			if ( $user->save() ) {
				$path = public_path()."/img/profiles/".$user->id;
				File::makeDirectory($path, 0777, true, true);

				$params = array();
				$params['subject'] = "Nuevo usuario de aplicación";
				$params['title'] = "Accesos aplicación";
				$params['content']['message'] = "Has sido dado de alta como usuario de aplicación de ".env('APP_NAME').", estos son tus accesos para tu cuenta:<br>";
				$params['content']['email'] = $user->email;
				$params['content']['password'] = $req->password;
				$params['email'] = $user->email;
				$params['view'] = 'mails.credentials';

				$user->contra = $password;

				if ( $this->mail($params) ){
					return response(['msg' => 'Registro exitoso, se ha enviado un correo de confirmación', 'Usuario' => $user, 'code' => 1],201);
				}
				return response(['msg' => 'Registro exitoso, el correo no se ha podido enviar', 'Usuario' => $user, 'code' => 1],201);
			} else {
				return [ 'msg' => 'Ha ocurrido un problema al registrarse.', 'code' => 0];
			}
		} else{
			return [ 'msg'=>'Este correo no está disponible.', 'code' => 0];
		}
	}

	/**
	 * Webservice para actualizar el perfil del usuario
	 *
	 * @return Arreglo con el usuario modificado
	 */
	public function updateProfile(Request $req)
	{
		$user = User::find($req->id);
		$pass = $req->password;
		$user->fill($req->except(['photo', 'password', 'email']));

		if ( $pass ) {
			$user->password = bcrypt($pass);
		}

		if ( $req->hasFile('photo') ){
			if ( File::exists(public_path()."/img/profiles/".$user->id) ){
				File::cleanDirectory(public_path()."/img/profiles/".$user->id);
			}
			$filename = time().'.'.$req->file('photo')->getClientOriginalExtension();
			$user->photo = '/img/profiles/'.$user->id.'/'.$filename;
			$req->file('photo')->move(
				public_path() . '/img/profiles/'.$user->id, $filename
			);
		}

		if ( $user->save() ){
			$user->contra = $pass;
			return response([ 'usuario' => $user, 'code' => 1], 200);
		}
		return [ 'msg'=>'Ha ocurrido un error, intente más tarde.', 'code' => 0];
	}

	/**
	 * Webservice para solicitar una contraseña provisional
	 *
	 * @return Mensaje de exito o msg al enviar correo
	 */
	public function recovery(Request $req)
	{
		$user = User::where(['email' => $req->email])->first();
		if ( $user ){
			if ( $user->role_id != 3 && $user->role_id != 4 ){
				return [ 'msg' => "Esta correo no pertenece a un usuario/auditor de la aplicación", 'code' => 0];
			}
			$pass = str_random(10);
			$user->password = bcrypt($pass);

			if ( $user->save() ){
				$params = array();
				$params['subject'] = "Usuario de sistema modificado";
				$params['content']['message'] = "Saludos ".$user->fullname.", se ha restablecido su contraseña:<br>";
				$params['content']['email'] = $user->email;
				$params['content']['password'] = $pass;
				$params['title'] = "Accesos al sistema";
				$params['email'] = $user->email;
				$params['view'] = 'mails.credentials';

				if ( $this->mail($params) ){
					return response(['msg' => 'Se ha enviado un correo', 'code' => 1],200);
				}
			}
			return response([ 'msg' => "Se ha enviado un correo", 'code' => 1], 200);
		} else {
			return [ 'msg' => "Este correo no se encuentra en el sistema", 'code' => 0];
		}
	}
	
    /**
     * Save a new application and validates if is a registered user.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_prospect(Request $req)
    {
        $user = User::find($req->user_id);
        $office = Office::find($req->office_id);
        $state = State::find($req->state_id);

        if (!$office) { return response(['msg' => 'Esta oficina no se encuentra disponible, seleccione otra', 'status' => 'error', 'refresh' => 'none'], 400); }
        if (!$state) { return response(['msg' => 'ID de estado inválido, trate nuevamente', 'status' => 'error', 'refresh' => 'none'], 404); }

        $prospect = New Application;

    	if ($user) {//Comes from a registered user
    		$prospect->user_id = $user->id;
    	} else {
            $prospect->fullname = $req->fullname;
            $prospect->email = $req->email;
            $prospect->phone = $req->phone;
            $prospect->regime = $req->regime;
            $prospect->rfc = strtoupper($req->rfc);
        }

        $prospect->office_id = $office->id;

        $prospect->save();

        #Details
        $detail = New ApplicationDetail;

        $detail->application_id = $prospect->id;
        $detail->state_id = $state->id;
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

    /**
     * Get the offices assoated by the customer
     *
     * @return \Illuminate\Http\Response
     */
    public function offices_by_user(Request $req)
    {
    	$offices = [];
    	$contracts = Contract::whereHas('application', function($query){
            $query->where('status', 1);
    	})
    	->where('user_id', $req->user_id)
    	->get();

    	foreach ($contracts as $con) {
    		$con->office->contrac_id = $con->id;
    		$con->office->type;
            $con->office->pictures;
            $con->office->municipality->state;
            $con->office->setHidden(['state_id', 'user_id', 'municipality_id', 'photo', 'created_at', 'updated_at', 'deleted_at']);

    		$offices[] = $con->office;
    	}

    	if (count($offices) > 0) { return response(['msg' => 'oficinas encontradas', 'code' => 1, 'oficinas' => $offices], 200); }

    	return response(['msg' => 'El cliente no cuenta con oficinas', 'code' => 0], 200);
    }

    /**
     * Get the notifications assoated by the customer
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_notifications(Request $req)
    {
    	$response = Notification::where('user_id', $req->user_id)->get();

    	foreach ($response as $noti) {
    		$noti->setHidden(['created_at', 'updated_at']);
    	}

    	if (count($response) > 0) {
	    	return response(['msg' => 'Notificaciones encontradas', 'code' => 1, 'data' => $response], 200);

    	}
	    return response(['msg' => 'El usuario no cuenta con notificaciones aún', 'code' => 0], 200);
    }

    /**
     * Mark a notification as read
     *
     * @return \Illuminate\Http\Response
     */
    public function mark_notification_as_read(Request $req)
    {
    	$notification = Notification::find($req->notificacion_id);

    	if (!$notification) {
	    	return response(['msg' => 'ID de notificación inválido', 'code' => 0], 200);
    	}

    	$notification->status = 1;
    	$notification->save();
    
	    return response(['msg' => 'Notificación marcada como leida correctamente', 'code' => 1], 200);
    }
    

	/**
     * Get the information about the payment state of a office
     *
     * @return \Illuminate\Http\Response
     */
    public function office_account_status(Request $req)
    {
    	/*Saldo anterior
		_
		Saldo actual
		_
		Cargo por atraso (esto sale sólo si se atrasa)
		_
		Porcentaje de interés adicional 10%

		Total a pagar pues ya el monto chilo
		Poner el monto en palabras*/
		$account = [];
    	$contract = Contract::find($req->contract_id);

    	if (!$contract){ return response(['msg' => 'ID de contrato inválido, trate nuevamente', 'code' => 0], 200);	}

    	//return $contract->payment_history->last()->payment;
    	$account['last_payment_quantity'] = count($contract->payment_history) > 0 ? $contract->payment_history->last()->payment : '0';
    	$account['last_payment_string'] = count($contract->payment_history) > 0 ? $contract->payment_history->last()->payment_str : 'Cero pesos 00/100 M.N.';
    	$account['last_payment_status'] = (count($contract->payment_history) > 0 ? ($contract->payment_history->last()->status == 1 ? 'Normal' : 'Atrasado') : 'Normal');
    	//Maybe add filter if it is the last payment...
    	$account['actual_payment_quantity'] =  ($contract->status == 1 ? '0' : ($contract->status == 2 ? $contract->office->price : $contract->office->price * 0.90));
    	$account['actual_payment_string'] =  ($contract->status == 1 ? 'Cero pesos 00/100 M.N.' : ($contract->status == 2 ? $contract->monthly_payment_delay_str : $contract->monthly_payment_str));
    	$account['actual_payment_status'] = ($contract->status == 1 ? 'Pagado' : ($contract->status == 2 ? 'Atrasado' : 'Por pagar'));

    	return response(['msg' => 'Estado de cuenta encontrado', 'code' => 1, 'data' => $account], 200);
    }

    /**
     * Check if a meeting room is available between the given horary, if so, save the meeting in calendar 
     *
     * @return \Illuminate\Http\Response
     */
    public function schedule_in_calendar(MeetingRequest $req)
    {
    	$meeting = new Meeting();
		$meeting->fill($req->all());

		$old = Meeting::whereRaw("((DATE_ADD('".$req->datetime_start."', INTERVAL 1 MINUTE) BETWEEN datetime_start AND datetime_end) OR (DATE_SUB('".$req->datetime_end."', INTERVAL 1 MINUTE) BETWEEN datetime_start AND datetime_end))")
		->where('office_id', $req->office_id)
		->get();

		if ( !$old->isEmpty() ){
			$meeting->date = date('d M Y', strtotime($meeting->datetime_start));
			$meeting->hour = date('H:i', strtotime($meeting->datetime_start));

			return response(['msg' => 'Esta fecha y hora no están disponibles de momento, porfavor, trate con diferentes datos.', 'data' => Input::all(), 'code' => 0], 200);
		}

		if ( $meeting->save() ){
			return response(['msg' => 'Sala de juntas agendada correctamente', 'code' => 1], 200);
		} else {
			return response(['msg' => 'Ha ocurrido un error agendando la sala de juntas, trate nuevamente', 'code' => 0], 200);
		}
    }

    /**
     * Return the calendar of the customer
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_calendar(Request $req)
    {
    	$response = Meeting::where('user_id', $req->user_id)->get();

    	foreach ($response as $meet) {
    		$meet->setHidden(['created_at', 'updated_at']);
    	}

    	return $response;
    }

    /**
     *==============================================================================================================================
     *=                                    Empiezan las funciones relacionadas a las auditorías                                    =
     *==============================================================================================================================
     */

    /**
     * Get available questions
     *
     * @return \Illuminate\Http\Response
     */
    public function get_questions(Request $req)
    {
    	$rows = Question::all();
    	foreach ($rows as $row) {
    		$row->category;
    	}

    	return response(['msg' => 'Preguntas enlistadas a continuación', 'code' => 1, 'data' => $rows], 200);
    }

    /**
     * Get available offices
     *
     * @return \Illuminate\Http\Response
     */
    public function get_offices(Request $req)
    {
    	$rows = Office::where('status', '!=', 0)->get();

    	return response(['msg' => 'Oficinas enlistadas a continuación', 'code' => 1, 'data' => $rows], 200);
    }

    /**
     * Initialize an audit
     *
     * @return \Illuminate\Http\Response
     */
    public function create_audit(Request $req)
    {
    	$office = Office::find($req->office_id);
    	$user = User::find($req->user_id);

    	if (!$office) { return response(['msg' => 'Officina no encontrada o inválida', 'code' => 0], 200); }
    	if (!$user) { return response(['msg' => 'Usuario no encontrada o inválido', 'code' => 0], 200); }
    	
    	$title = "Auditoria para $office->name";

    	$row = New Audit;

    	$row->office_id = $office->id;
    	$row->user_id = $user->id;
    	$row->title = $title;
    	
    	$row->save();

    	return response(['msg' => 'Auditoria iniciada correctamente', 'code' => 1, 'data' => $row], 200);
    }

    /**
     * Save the answer (detail for a question)
     *
     * @return \Illuminate\Http\Response
     */
    public function add_audit_deatil(Request $req)
    {
    	$audit = Audit::find($req->audit_id);
    	$question = Question::find($req->question_id);

    	if (!$audit) { return response(['msg' => 'Auditoría no encontrada o inválida', 'code' => 0], 200); }
    	if (!$question) { return response(['msg' => 'Pregunta no encontrada o inválida', 'code' => 0], 200); }

    	$exist = AuditDetail::where('audit_id', $audit->id)->where('question_id', $question->id)->first();

    	if ($exist) { return response(['msg' => 'Esta pregunta ya ha sido respondida', 'code' => 0], 200); }

    	$row = New AuditDetail;

    	$row->audit_id = $audit->id;
    	$row->question_id = $question->id;
    	$row->answer = $req->answer;
    	$row->detail = $req->detail;

    	$row->save();

    	return response(['msg' => 'Detalle guardado correctamente', 'code' => 1, 'data' => $row], 200);
	}

	/**
     * Update the answer (detail for a question)
     *
     * @return \Illuminate\Http\Response
     */
    public function update_audit_deatil(Request $req)
    {
    	$row = AuditDetail::find($req->audit_detail_id);
    	
    	if (!$row) { return response(['msg' => 'Registro no encontrado', 'code' => 0], 200); }

    	$row->answer = $req->answer;
    	$row->detail = $req->detail;

    	$row->save();

    	return response(['msg' => 'Respuesta modificada correctamente', 'code' => 1, 'data' => $row], 200);
    }

	/**
     * Save the answer (detail for a question
     *
     * @return \Illuminate\Http\Response
     */
    public function save_question_photo(Request $req)
    {
    	$detail = AuditDetail::find($req->audit_detail_id);

    	if (!$detail) { return response(['msg' => 'ID de detalle inválido', 'code' => 0], 200); }

    	if (!is_array($req->fotos)) {
    		return response(['msg' => 'El parámetro fotos no es un array', 'code' => 0, 'data' => $req->fotos], 200);
    	}

    	foreach ($req->fotos as $key => $foto) {
    		$binary_data = base64_decode( $foto );
	        $path = 'img/audits/'.$detail->audit->id.'/'.$detail->id;
	        $name = time().$key.$req->extension;
	        $this->make_path($path);
	        $result = file_put_contents( $path.'/'.$name, $binary_data );

	    	$row = New AuditPhoto;

	    	$row->audit_detail_id = $detail->id;
	    	$row->path = $path.'/'.$name;

	    	$row->save();
    	}

    	return response(['msg' => 'Fotos almacenada correctamente', 'code' => 1, 'data' => $row], 200);
    }

    /**
     * Delete the answer (detail for a question
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_question_photo(Request $req)
    {
    	$photo = AuditPhoto::find($req->audit_photo_id);
    	
    	if (!$photo) { return response(['msg' => 'ID de foto inválido', 'code' => 0], 200); }

    	$this->delete_path($photo->path);//Delete the photo

    	$photo->delete();

    	return response(['msg' => 'Foto eliminada correctamente', 'code' => 1,], 200);
    }

    /**
     * Finalize an audit
     *
     * @return \Illuminate\Http\Response
     */
    public function conclude_audit(Request $req)
    {
    	$audit = Audit::find($req->audit_id);

    	if (!$audit) { return response(['msg' => 'Auditoría no encontrada o inválida', 'code' => 0], 200); }

    	$audit->status = 1;//Finalize it

    	$audit->save();
    	
    	return response(['msg' => 'Auditoría finalizada correctamente', 'code' => 1, 'data' => $audit], 200);
    }

    /**
     * Finalize an audit
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel_audit(Request $req)
    {
    	$audit = Audit::find($req->audit_id);

    	if (!$audit) { return response(['msg' => 'Auditoría no encontrada o inválida', 'code' => 0], 200); }

    	$details = AuditDetail::where('audit_id', $audit->id)->get();
    	foreach ( $details as $detail ) {
    		if ( $detail->photos->count() ) {
    			foreach ( $detail->photos as $photo ) {
    				$photo->delete();
    			}
    		}
    		$detail->delete();
    	}

    	$audit->delete();

        AuditDetail::where('audit_id', $audit->id)->delete();

    	return response(['msg' => 'Auditoría cancelada correctamente', 'code' => 1, 'data' => $audit], 200);
    }

    /**
     * Get all the information about an audit
     *
     * @return \Illuminate\Http\Response
     */
    public function get_audit_info(Request $req)
    {
    	$result = [];
    	$audit = Audit::find($req->audit_id);

    	if (!$audit) { return response(['msg' => 'Auditoría no encontrada o inválida', 'code' => 0], 200); }
    	
    	foreach ($audit->auditDetail as $detail) {
    		$result[] = 
    			[
                    'audit_detail_id' => $detail->id,
    				'question_id' => $detail->question->id, 
    				'question' => $detail->question->question, 
    				'answer' => $detail->answer, 
    				'detail' => $detail->detail,
    				'photos' => $detail->photos
    			];
    	}

    	return response(['msg' => 'Información de auditoría encontrada', 'code' => 1, 'data' => $result], 200);

    }
}
