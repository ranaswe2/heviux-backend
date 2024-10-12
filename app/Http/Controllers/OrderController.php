<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductSize;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function getDeliveredOrderList()
    {
        // Check if the authenticated user is an admin
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        // Get delivered orders with related product and user information
        $orders = Order::where('is_delivered', true)
            ->with(['product', 'user:id,name,phone'])
            ->get(['product_id', 'quantity', 'size', 'user_id', 'is_delivered']);

        return response()->json($orders);
    }

    public function getPendingOrderList()
    {
        // Check if the authenticated user is an admin
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        // Get pending orders with related product and user information
        $orders = Order::where('is_delivered', false)
            ->with(['product', 'user:id,name,phone'])
            ->get(['product_id', 'quantity', 'size', 'user_id', 'is_delivered']);

        return response()->json($orders);
    }

    public function getOrderList()
    {
        // Check if the authenticated user is an admin
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        // Get all orders with related product and user information
        $orders = Order::with(['product', 'user:id,name,phone'])
            ->get(['product_id', 'quantity', 'size', 'user_id', 'is_delivered']);

        return response()->json($orders);
    }

    public function placeOrder(OrderRequest $request)
    {
        $validatedData = $request->validated();
        
        $validatedData['user_id'] = Auth::id();
        $validatedData['process_id'] = Str::uuid()->toString();
        $validatedData['is_delivered'] = false;

        $available = ProductSize::where('product_id', $validatedData['product_id'])->first();

        if (!$available || $available->{$validatedData['size']} < $validatedData['quantity']) {
            return response()->json([
                "message" => "Sorry, only ". $available->{$validatedData['size']}." products available for the selected size!"
            ], 200);
        }

        $order = Order::create($validatedData);

        $sizeController= new ProductSizeController();
        $sizeController->decrementProductSize($validatedData['product_id'], $validatedData['size'], $validatedData['quantity']);

        $totalAmount = $order->product->price * $order->quantity;
        $trx= new TransactionController();
        $transaction = $trx->createTransaction($order,$totalAmount);

        return response()->json([
            'process_id' => $transaction['process_id'], 
            'total_amount' => $transaction['total_amount']
        ], 201);
    }

    
    public function deliverOrder($orderId)
    {        
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        $order= Order::where('order_id', $orderId)->get();
        $trx= Transaction::where('process_id', $order->process_id)->get();

        if($trx->transaction_id && ($trx->status == 'completed')){  
            Order::where('order_id', $orderId)
            ->update([
                'is_delivered' => true,
            ]);

            return response()->json(["message" => "Successfully delivered the order!"], 200);
        }
        else{
            return response()->json(["message" => "Sorry, payment status is $trx->status!"], 201);
        }

    }
}
