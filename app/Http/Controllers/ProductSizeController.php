<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Requests\ProductSizeRequest;

class ProductSizeController extends Controller
{
    public function store(ProductSizeRequest $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Invalid request format.'], 400);
        }
        
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        $validatedData = $request->validated();
    
        // Set 'created_by' using the authenticated user
        $validatedData['created_by'] = $admin->id;
    
        $productSize = ProductSize::create($validatedData);
        return response()->json($productSize, 201);
    }    

    public function show($id)
    {
        $productSize = ProductSize::findOrFail($id);
        return response()->json($productSize);
    }
    
    public function update(ProductSizeRequest $request, $id)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $productSize = ProductSize::findOrFail($id);
        $validatedData = $request->validated();

        $validatedData['modified_by'] = $admin->id;

        $productSize->update($validatedData);
        
        return response()->json($productSize, 200);
    }

    public function decrementProductSize($productId, $size, $quantity)
    {
        $productSize = ProductSize::where('product_id', $productId)->firstOrFail();

        // Update the quantity in the product size table
        $productSize->decrement($size, $quantity);
    }

    public function incrementProductSize($productId, $size, $quantity)
    {
        $productSize = ProductSize::where('product_id', $productId)->firstOrFail();

        // Update the quantity in the product size table
        $productSize->increment($size, $quantity);
    }

    public function addToProductSize($processId)
    {
        // Fetch orders based on the process_id
        $orders = Order::where('process_id', $processId)->get();

        foreach ($orders as $order) {
            // Update product sizes using the incrementProductSize function
            $this->incrementProductSize($order->product_id, $order->size, $order->quantity);
            
            $order->delete();
        }
    }

}
