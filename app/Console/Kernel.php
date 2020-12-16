<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'schedule:run'=> '\App\Console\Commands\DailyScheduleCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
        //     \Illuminate\Support\Facades\Log::error('deleting comments');
        //     $older = (new \Carbon\Carbon)->subDays(15)->toDateTimeString();
        //     \App\Rate::where('status', '!=', 'approved')->where('created_at', '<=', $older)->delete();
        // })->everyMinute()->when(function() {
        //     return true;
        // });
    }
}
