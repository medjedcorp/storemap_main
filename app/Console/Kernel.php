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
        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //     DB::table('recent_users')->delete();
        // })->hourly();

        // スケジュール設定
        // 1時間ごとにバックアップコマンドを実行
        // $schedule->command('backup:run')->hourly();
        // 毎日３時に実行
        // $schedule->command('backup:run')->dailyAt('3:00');
        // 毎日1:00と13:00時に実行
        // $schedule->command('backup:run')->twiceDaily(1, 13);
        // $schedule->command('backup:run')->everyFiveMinutes();
        // $schedule->command('backup:run')->everyMinute();
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
