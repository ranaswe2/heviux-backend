<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    
    public function create(Request $request)
    {
        $user_id= $request->input('user_id');
        $existingAdmin = User::where('id', $user_id)->where('is_admin', true)->first();
        
        if (!$existingAdmin) {
            return response()->json(['Message' => 'The user is not an admin yet!'], 404);
        }

        // Remove existing Super Admin
        $existingSuperAdmin = SuperAdmin::where('is_active', true)->first();
        if ($existingSuperAdmin) {
            $existingSuperAdmin->update(['is_active' => false]);
        }

        // Create new Super Admin
        $superAdmin = SuperAdmin::create([
            'user_id' => $user_id,
            'is_active' => true,
        ]);

        return redirect()->intended('/api/logout/');
    }
    
    public function getSuperAdminProfile()
    {
        $admin = auth()->user();
        $superAdmin = SuperAdmin::where('is_active', true)->first();
        if($superAdmin->user_id == $admin->id){
            return response()->json($admin, 200);
        }
        return response()->json(['Message'=>'Active super admin not found!'], 404);
    }
    
    public function verifyPassword(Request $request)
    {

        $email = auth()->user()->email;
        $userFromDB = User::where('email', $email)->first();

        if (!$userFromDB || !Hash::check($request->input('password'), $userFromDB->password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }

        return response()->json(['message' => 'Password verified successfully'], 200);
    }

}
