<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequest;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $offers = Offer::all();
        return response()->json($offers, 200);
    }

    // public function show($id)
    // {
    //     $admin = auth()->user();
    //     if (!$admin || !$admin->is_admin) {
    //         return response()->json(['error' => 'Unauthorized access'], 403);
    //     }

    //     $offer = Offer::findOrFail($id);
    //     return response()->json($offer, 200);
    // }

    public function store(OfferRequest $request)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $validatedData = $request->validated();
        $validatedData['created_by'] = Auth::id(); // Set created_by field
        
        $offer = Offer::create($validatedData);
        return response()->json($offer, 201);
    }

    public function update(OfferRequest $request, $id)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $offer = Offer::findOrFail($id);
        $validatedData = $request->validated();
        $validatedData['modified_by'] = Auth::id(); // Set modified_by field
        
        $offer->update($validatedData); 
        return response()->json($offer, 200);
    } 

    public function destroy($id)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $offer = Offer::findOrFail($id);
        $offer->delete();        
        $validatedData['modified_by'] = Auth::id(); // Set modified_by field
        return response()->json(['message' => 'Offer deleted successfully.'], 200);
    }

    public function show($category)
    {
        $currentDateTime = Carbon::now();

        $offer = Offer::where('category', 'all')
            ->orWhere('category', $category)
            ->where('start_date', '<=', $currentDateTime)
            ->where('end_date', '>=', $currentDateTime)
            ->first();

        if ($offer) {
            return response()->json($offer, 200);
        } else {
            return response()->json(['message' => 'No available offer for the given category at the present time.'], 404);
        }
    }

    public function undeleteOffer($id)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        $offer = Offer::withTrashed()->find($id);

        if (!$offer) {
            return response()->json(['message' => 'Offer not found.'], 404);
        }

        $offer->restore();

        return response()->json(['message' => 'Offer restored successfully.'], 200);
    }
}

