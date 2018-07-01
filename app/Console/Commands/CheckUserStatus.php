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
    protected $description = 'Verificar el status de prospectos para mandar cierto tipo de plantilla';

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
        /*$prospectos = Application::all();
        $prospectos->each(function(){

        });*/
    }
}
