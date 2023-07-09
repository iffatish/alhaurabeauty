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
        //Run this command daily at midnight (00:00) to create the daily sales report for every user registered in the system.
        $schedule->call('App\Http\Controllers\ReportController@createDailySalesReport')->erveryMinute();
        //Run this command monthly to create the monthly sales report for every user registered in the system.
        $schedule->call('App\Http\Controllers\ReportController@createMonthlySalesReport')->monthly();
        //Run this command yearly to create the yearly sales report for every user registered in the system.
        $schedule->call('App\Http\Controllers\ReportController@createYearlySalesReport')->yearly();
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
