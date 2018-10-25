<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\GeneralFunctions;
use App\Models\Calendar;
use App\Models\User;
use Mail;

class CheckNotificationsCalendar extends Command
{
	use GeneralFunctions;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:CheckNotificationsCalendar';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Comando para verificar las tareas del dia actual por usuario';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Mexico_city');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$today = date('Y-m-d', strtotime('now'));
		$users = User::has('office')->get();
		$users->each(function($user, $key) use($today){
			$content = $tr = "";
			$tasks = $user->office->tasks->where('datetime_start', '>=', $today.' 00:00:00')->where('datetime_start', '<=', $today.' 23:59:59');
			$count_tasks = count($tasks);
			$tasks->each(function($task, $key) use (&$tr){
				$tr .= "<tr><td>".date('H:i', strtotime($task->datetime_start)) ."</td><td>".$task->title."</td><td>".$task->description."</td</tr>";
			});
			$content = "Saludos ".$user->fullname.", usted tiene ".$count_tasks." tareas para el día de hoy.";

			if ( $count_tasks ){
				$fields = array(
					'subject' => 'Recordatorio de tareas',
					'title' => 'Tareas pendientes para el día de hoy',
					'content' => $content,
					'reminders' => $tr,
					'email' => $user->email,
					'view' => 'mails.reminder'
				);

				$fields = json_encode($fields);

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://fastoffice.app/apiv1/enviar-correo");
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

				$response = curl_exec($ch);
				curl_close($ch);
			}
		});
	}
}
