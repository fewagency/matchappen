<?php

namespace Matchappen\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Matchappen\Console\Commands\CancelExpiredBookings;
use Matchappen\Console\Commands\HandleEmailRejection;
use Matchappen\Console\Commands\SendEvaluations;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEvaluations::class,
        CancelExpiredBookings::class,
        HandleEmailRejection::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('evaluations:send')->everyTenMinutes()->withoutOverlapping();
        $schedule->command('bookings:cancel-expired')->everyMinute()->withoutOverlapping();
    }
}
