<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            // Kode untuk menjalankan tugas yang dijadwalkan
            DB::table('reported_questions')->where('created_at', '<', now()->subDays(30))->delete();
            DB::table('reported_replies')->where('created_at', '<', now()->subDays(30))->delete();
            DB::table('reported_users')->where('created_at', '<', now()->subDays(30))->delete();
        })->dailyAt('00:00')->timezone('Asia/Jakarta');
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
