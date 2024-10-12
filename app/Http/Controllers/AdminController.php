<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         return redirect()->intended('/api/admin/profile');
    //     }

    //     return response()->json(['login' => 'Invalid credentials'],401);
    // }


    public function create(Request $request)
    {
        $user_id= $request->input('user_id');
        $existingUser = User::where('id', $user_id)->first();

        if ($existingUser) {
            $existingUser->update(['is_admin' => true]);
            
            return response()->json(['Message' => 'Successfully added ' .$existingUser->name . ' to admin panel'], 200);
        }
        return response()->json(['Message' => 'User ID ' .$user_id. ' not found!'], 404);
    }

    public function remove(Request $request)
    {
        $user_id= $request->input('user_id');
        $existingAdmin = User::where('id', $user_id)->where('is_admin', true)->first();

        if ($existingAdmin) {
            $existingAdmin->update(['is_admin' => false]);

            return response()->json(['Message' => 'Successfully removed ' .$existingAdmin->name. ' from admin panel'], 200);
        }
        return response()->json(['Message' => 'User is not an admin yet!'], 201);
    }

    public function getAdminProfile()
    {
        $admin = auth()->user();

        if (!$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        return response()->json($admin);
    }

    public function getAdminList()
    {
        $admins = User::where('is_admin', true)->get();
    
        // Check if the authenticated user is an admin
        $authenticatedUser = auth()->user();
        if (!$authenticatedUser || !$authenticatedUser->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
    
        return response()->json($admins);
    }

    
    
}
