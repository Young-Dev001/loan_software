<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Http;
class MessageController extends Controller
{

    public function sendSms(Request $request)
    {
        $url = "https://sms.crossgatesolutions.com:18095/v1/bulksms/messages";
    
        // Prepare the payload
        $payload = [
            "profile_code" => "2402051",
            "messages" => [
                [
                    "mobile_number" => $request->input('phone_number'),
                    "message" => $request->input('message'),
                    "message_type" => "transactional",
                    "message_ref" => "76387871a0bd4f44afcbf3af8fb53054"
                ]
            ],
            "dlr_callback_url" => "http://example.com"
        ];
    
        // Make the HTTP request to send the SMS
        $response = Http::withHeaders([
            'api-key' => 'YzFkNDQzOWFjYTMzNmNiMUlELWI0YzZkNzdlZGJmNDQ5Njc4YmRmZGJjYmI3ZDVjYTA5',
            'Content-Type' => 'application/json'
        ])->post($url, $payload);
        
        // Check if the SMS was sent successfully
        if ($response->successful()) {
            // SMS sent successfully
            $notification = array(
                'message' => 'Message sent successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            // Error sending SMS
            $notification = array(
                'message' => 'Error sending Message!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function index()
    {
        $members = Member::all();
        return view('admin.messages.index', compact('members'));
    }
    // Create a new message
    public function create(Request $request)
    {
        $message = new Message();
        $message->title = $request->input('title');
        $message->body = $request->input('body');
        $message->save();

        return response()->json(['message' => 'Message created successfully'], 201);
    }

    // Read a message
    public function read($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        return response()->json($message, 200);
    }

    // Update a message
    public function update(Request $request, $id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $message->title = $request->input('title');
        $message->body = $request->input('body');
        $message->save();

        return response()->json(['message' => 'Message updated successfully'], 200);
    }

    // Delete a message
    public function delete($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted successfully'], 200);
    }
}
