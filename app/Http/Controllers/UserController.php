<?php

namespace App\Http\Controllers;

use illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    public function register(UserRequest $request)
    {
        
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Invalid request format.'], 400);
        }

        $user = $this->createUser($request->validated());
        $this->sendOtp($user);

        $request->session()->put('email', $user->email);
        $request->session()->put('password', $user->password);
        $request->session()->put('registration_time', now());
        event(new Registered($user));

        return response()->json(['message' => 'An OTP has sent to your email. Now Verify your account using the OTP.'], 201);
    }

    protected function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'] ?? null,
            'current_otp' => strval(rand(100000, 999999)), // Generate OTP and store it in the database
        ]);
    }

    protected function sendOtp(User $user)
    {
        // You can customize the email content and subject as needed
        $emailContent = "Hello $user->name, Your OTP for Heviux verification is: $user->current_otp";

        Mail::raw($emailContent, function ($message) use ($user) {
            $message->to($user->email)->subject('Registration OTP');
        });
    }

    public function resendOTP(Request $request)
    {
        $email = $request->session()->get('email');
        $request->session()->put('registration_time', now());
        $user = User::where('email', $email)->first();

        // Generate a new OTP
        $newOTP = strval(rand(100000, 999999));
        $user->update(['current_otp' => $newOTP]);
        $this->sendOtp($user);

        return response()->json(['message' => 'Another OTP has sent to your email. Now Verify your account using the OTP.'], 201);
    }

    public function verifyOtp(Request $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Invalid request format.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'current_otp' => 'required|numeric|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $email = $request->session()->get('email');
        $registrationTime = $request->session()->get('registration_time');

        $user = User::where('email', $email)->first();

        if ($user && $user->current_otp && ($request->current_otp == $user->current_otp) && now()->lt($registrationTime->addMinutes(5))) {
            
            $user->update(['is_verified' => true, 'current_otp' => null]);

            return response()->json(['message' => 'Verification successful'], 200);
        }

        return response()->json(['error' => 'Invalid OTP'], 401);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            
            $user = auth()->user();
            if (!$user || !$user->is_admin) {
                return redirect()->intended('/api/user/profile');
            }
        
            return redirect()->intended('/api/admin/profile');
        }

        return response()->json(['login' => 'Invalid credentials']);
    }

    public function getUserProfile()
    {
        $user = auth()->user();

        return response()->json($user);
    }


    public function getUserProfileByID($userId)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $user = User::where('id', $userId)->get();
        return response()->json($user);
    }


    public function getUserList()
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $users = User::get();
        return response()->json($users);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        // Implement Change password logic

        return response()->json(['message' => 'Password changed successfully']);
    }
    
    public function updateUserAddressAndPhone(Request $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Invalid request format.'], 400);
        }
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'address' => 'nullable|string|max:511',
            'phone' => 'nullable|string|regex:/^(\+?[0-9]{1,4}\s?)?([0-9]\s?[-.]?\s?){6,14}[0-9]$/',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $updated = User::where('id', $user->id)
        ->update([
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
        ]);
        
        if ($updated) {
            return response()->json(['message' => 'Profile updated successfully'], 200);
        }
        
        return response()->json(['message' => 'Update Failed!'], 401);
    }

    public function updateUserProfilePicture(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $profilePicture = $request->file('profile_picture');
        $imageName = $user->id . '.' . time() . '.' . $profilePicture->getClientOriginalExtension();
        $imagePath = 'profile_images/';

        // Move the image to the storage path
        $profilePicture->move(public_path($imagePath), $imageName);

        $updated = User::where('id', $user->id)
                        ->update([
                            'image_name' => $imageName,
                            'image_path' => $imagePath,
                        ]);

        if ($updated=true) {
            return response()->json(['message' => 'Profile picture updated successfully']);
        }
        
        return response()->json(['message' => 'Update Failed!'], 401);
    }


    public function getUserCartItems()
    {
        $user = auth()->user();
        $userOrders = Cart::where('user_id', $user->id)->get();

        return response()->json(['cart_items' => $userOrders], 200);
    }

    public function getUserOrderList()
    {
        $user = auth()->user();
        $userOrders = Order::where('user_id', $user->id)->get();

        return response()->json(['orders' => $userOrders], 200);
    }

    public function getUserOrderListByID($userId)
    {
        $userOrders = Order::where('user_id', $userId)->get();

        return response()->json(['orders' => $userOrders], 200);
    }








    public function logout()
    {
        Auth::logout();
        
        return response()->json(['message' => 'Logged out successfully']);
    }


}
