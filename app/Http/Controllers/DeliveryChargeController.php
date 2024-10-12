<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryCharge;

class DeliveryChargeController extends Controller
{
    
    public function index()
    {
        $deliveryCharge = DeliveryCharge::firstOrFail();
        return response()->json($deliveryCharge);
    }
    

    public function update(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $deliveryCharge = DeliveryCharge::firstOrFail();
        
        $user = auth()->user();

        if ($user && $user->is_admin) {
            $deliveryCharge->update([
                'price' => $request->input('price'),
                'modified_by' => auth()->id(),
            ]);

            return response()->json($deliveryCharge);
        }
        
        return response()->json(['error' => 'Unauthorized access'], 403);
    }
}
