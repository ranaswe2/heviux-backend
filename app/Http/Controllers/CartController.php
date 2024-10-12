<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Requests\CartUpdateRequest;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(CartRequest $request)
    {   
        // dd(Auth::check());
        //  dd(session()->all());
        // dd(Auth::user());
        $cartItem = Cart::create([
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'size' => $request->input('size'),
            'user_id' => Auth::id()
        ]);

        return response()->json($cartItem, 201);
    }


    public function update(CartUpdateRequest $request, $id)
    {
        $user = Auth::user();
        $cartItem = Cart::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $cartItem->update([
            'quantity' => $request->input('quantity'),
            'size' => $request->input('size'),
        ]);

        return response()->json($cartItem, 200);
    }

    public function index()
    {
        $user = Auth::user();
        
        dd(Auth::user());
        $cartItems = Cart::where('user_id', $user->id)->get();

        return response()->json($cartItems,200);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $cartItem = Cart::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $cartItem->delete();

        return response()->json(['message' => 'Product removed successfully!'], 200);
    }

}
