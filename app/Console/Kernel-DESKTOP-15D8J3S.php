<?php

namespace App\Console;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {

            $checkUnpaidOrders= new TransactionController();
            $checkUnpaidOrders->manageUnpaidTransaction();
            
        })->everyMinute();

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
