<?php

namespace Ibrahim\Movie\Console;

use Ibrahim\Movie\Console\Commands\SyncCategoriesCommand;
use Ibrahim\Movie\Console\Commands\SyncMoviesCommand;
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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);
        $schedule->command(SyncMoviesCommand::class)
            ->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */

}
