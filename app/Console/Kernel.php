<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CheckUserStatus::class,
        Commands\CheckNotificationsCalendar::class,
        Commands\CheckPaymentStatus::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:CheckPaymentStatus')
        ->everyMinute();
        #->daily()
        #->at('02:00');


        $schedule->command('command:CheckNotificationsCalendar')->weekdays()
            ->at('06:00');

        $schedule->command('command:CheckUserStatus')
        ->dailyAt('07:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
