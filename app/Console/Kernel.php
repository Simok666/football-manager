<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('payments:set-status-and-bill-notifications')
             ->dailyAt('09:00')
             ->when(function () {
                 $now = now();
                 $currentMonth = $now->month;
                 $currentDay = $now->day;
                 
                 // Run between 25th of current month and 5th of next month
                 return ($currentDay >= 25 && $currentDay <= 31) || 
                        ($currentDay >= 1 && $currentDay <= 5);
             });

        $schedule->command('payments:send-overdue-notifications')
             ->dailyAt('10:00')
             ->when(function () {
                 $now = now();
                 $currentDay = $now->day;
                 
                 // Run daily from 6th of the month onwards
                 return $currentDay >= 6;
             });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
