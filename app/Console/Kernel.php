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
        $schedule->command('weather:warning')->dailyAt('21:00');
        $schedule->command('fund:before-close')->dailyAt('14:40');

//        $schedule->command('common:training-day')->dailyAt('18:30');
        $schedule->command('common:meeting-day')->dailyAt('12:00');

//        $schedule->command('test1')->everyMinute();

        // 馒头爬虫 10:00-23:59之间允许执行
        $h = date('H');
        if ($h >= 10 && $h <= 23) {

            // 每16分钟执行一次
            $schedule->command('pt:m-team-crawler')->cron('*/16 * * * *')->runInBackground();
        }

        // 硬盘检查 每周五 10点推送
        $schedule->command('disk:check-health')->cron('0 10 * * 5')->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
