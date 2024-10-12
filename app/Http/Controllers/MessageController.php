<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function sendToAdmin(MessageRequest $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $msgImage = $request->file('image');
        $imageName =  time() . '.' . $msgImage->getClientOriginalExtension();
        $imagePath = 'message_images/'.$imageName;

        // Move the image to the storage path
        $msgImage->move(public_path($imagePath), $imageName);


        $messageData = $request->validated();
        $messageData['sender_id'] = Auth::id();
        $messageData['receiver_id'] = 6; // Admin Id = 6

        if ($request->hasFile('image')) {
            $messageData['image_path'] = $imagePath;
        }





        $message = Message::create($messageData);

        return response()->json(['message' => $message, 'status' => 'Message sent successfully'], 201);
    }

    public function sendToUser(MessageRequest $request)
    {
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $msgImage = $request->file('image');
        $imageName =  time() . '.' . $msgImage->getClientOriginalExtension();
        $imagePath = 'message_images/'.$imageName;

        // Move the image to the storage path
        $msgImage->move(public_path($imagePath), $imageName);


        $messageData = $request->validated();
        $messageData['sender_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $messageData['image_path'] = $imagePath;
        }

        $message = Message::create($messageData);

        return response()->json(['message' => $message, 'status' => 'Message sent successfully'], 201);
    }


    public function receiveUserSide()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            return response()->json(['Message' => 'Admin can not view his individual message!'], 402);
        }

        $receivedMessages = Message::where('receiver_id', $user->id)
        ->orWhere('sender_id', $user->id)
        ->get();   
        // Self message: Right side
        // Admin/other message: Left Side

        return response()->json(['messages' => $receivedMessages], 200);
    }


    public function receiveAdminSide($userID)
    {
        
        $admin = auth()->user();
        if (!$admin || !$admin->is_admin) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $receivedMessages = Message::where('receiver_id', $userID)
        ->orWhere('sender_id', $userID)
        ->get();   
        // Self message: Right side
        // Admin/other message: Left Side

        return response()->json(['messages' => $receivedMessages], 200);
    }

    public function delete($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json(['status' => 'Message deleted successfully'], 200);
    }
}

