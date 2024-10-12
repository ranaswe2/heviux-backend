<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{ 
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            
            $user = auth()->user();

            if (!$user->is_admin) {
                return redirect()->intended('/api/user/profile');
            }
            else {     
                $superAdmin = SuperAdmin::where('user_id', $user->id)->where('is_active', true)->first();
                
                if ($superAdmin) {
                    return redirect()->intended('/api/super-admin/profile');
                }

                return redirect()->intended('/api/admin/profile');
            }
        
        }

        return response()->json(['login' => 'Invalid credentials']);
    }

  
    public function logout()
    {
        Auth::logout();
        
        return response()->json(['message' => 'Logged out successfully']);
    }
    
}
