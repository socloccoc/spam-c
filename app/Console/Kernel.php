<?php

namespace App\Console;

use App\CrontabSetting;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $setting = CrontabSetting::first();
        if($setting['status'] == 0){
            return;
        }
        if ($setting['time_once'] == 0) {
            $schedule->command('spam:start')
                ->everyThirtyMinutes()->appendOutputTo(storage_path('logs/spam_card.log'));
        } else if ($setting['time_once'] == 1) {
            $schedule->command('spam:start')
                ->hourly()->appendOutputTo(storage_path('logs/spam_card.log'));
        } else {
            $cron = '0 */' . $setting['time_once'] . ' * * *';
            $schedule->command('spam:start')
                ->cron($cron)->appendOutputTo(storage_path('logs/spam_card.log'));
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected
    function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
