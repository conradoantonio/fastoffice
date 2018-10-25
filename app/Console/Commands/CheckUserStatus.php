<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use App\Models\Template;

class CheckUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CheckUserStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar plantillas automaticas en secuencia a los prospectos';

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
        $prospectos = Application::where('status',0)->get();
        $automaticTemplates = Template::where(['user_status_id' => 0, 'type_id' => 2])->get();
        if ( $automaticTemplates->isEmpty() ) { return; }

        $prospectos->each(function($prospecto, $key) use ($automaticTemplates) {
            if ( !$prospecto->sendHistoryTemplate ){
                return;
            }
            $find = $automaticTemplates->where('id', $prospecto->sendHistoryTemplate->template_id)->first();

            if ( !$find ){
                $next = $automaticTemplates->first();
                $prospecto->sendHistoryTemplate->template_id = $next->id;
                $prospecto->sendHistoryTemplate->save();
            } else {
                $next = $automaticTemplates->where('id', '>', $prospecto->sendHistoryTemplate->template_id)->first();

                if ( $next ){
                    $prospecto->sendHistoryTemplate->template_id = $next->id;
                    $prospecto->sendHistoryTemplate->save();
                } else {
                    return;
                }
            }

            $fields = array(
                'subject' => 'Información Fast Office',
                'title' => $next->name,
                'content' => ['message' => $next->content, 'attachments' => $next->attachments],
                'email' => $prospecto->email?$prospecto->email:$prospecto->customer->email,
                'view' => 'mails.templates'
            );
            
            $fields = json_encode($fields);
            
            \Log::info('Estos son los parámetros de plantilla automática '.$fields);
            
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
            
            #\Log::info('Se ejecuto el curl para enviar plantilla automática');
        });
    }
}
