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
        // Commands\Inspire::class,
        Commands\Alertas::class,
        Commands\Mailing::class,
        Commands\Semaforos::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('alerta')
                  ->dailyAt('6:00');
        
        $schedule->command('mailing')
                  ->weekly()
                  ->fridays();

        $schedule->command('semaforos')
                  ->weekly()
                  ->mondays();
    }
}
