<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Requests\DiscountRequest;

class DiscountController extends Controller
{
    public function store(DiscountRequest $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Invalid request format.'], 400);
        }

        $admin = auth()->user();

        $validatedData = $request->validated();
        $validatedData['created_by'] = $admin->id;

        $discount = Discount::create($validatedData);

        return response()->json($discount, 201);
    }

    public function update(DiscountRequest $request, $productId)
    {
        $admin = auth()->user();

        $discount = Discount::where('product_id', $productId)->firstOrFail();

        $validatedData = $request->validated();
        $validatedData['product_id'] = $productId;
        $validatedData['modified_by'] = $admin->id;

        $discount->update($validatedData);

        return response()->json($discount, 200);
    }

    public function show($id)
    {
        $discount = Discount::findOrFail($id);
        return response()->json($discount);
    }
    
    public function destroy($productId)
    {
        $discount = Discount::where('product_id', $productId)->firstOrFail();
        $discount->delete();
        return response()->json(null, 204);
    }
}
