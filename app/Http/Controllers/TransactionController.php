<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function createTransaction(Order $order, $totalAmount)
    {
        $transaction = Transaction::create([
            'process_id' => $order->process_id,
            'total_amount' => $totalAmount ,
            'status' => 'pending',
        ]);

        return $transaction;
    }

    
    public function manageUnpaidTransaction()  
    {

        /* 
         * If user failed to pay within 15 minute from order, order will cancel
         * This function is called from app/console/Kernel.php file
         * To execute it, run the command: php artisan schedule:run
        */

        $unpaidOrders = Transaction::where('status', 'pending')
                        ->whereNull('transaction_id')
                        ->where('created_at', '<=', now()->subMinutes(15))
                        ->get();

        foreach ($unpaidOrders as $trx) {
            
        $productSize= new ProductSizeController;
        $productSize->addToProductSize($trx->process_id);

        $trx->update(['status' => 'failed']);
        }
    }
}
