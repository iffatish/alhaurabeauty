<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Run these three commands daily at midnight (00:00) to create the reports for every user registered in the system.
        $schedule->call('App\Http\Controllers\ReportController@createDailySalesReport')->daily();
        $schedule->call('App\Http\Controllers\ReportController@createMonthlySalesReport')->daily();
        $schedule->call('App\Http\Controllers\ReportController@createYearlySalesReport')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
