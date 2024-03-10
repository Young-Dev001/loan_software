<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;

class EmailController extends Controller
{

    public function index()
    {
        return view('admin.emails.index');
    }
    // Create a new email
    public function create(Request $request)
    {
        $email = new Email();
        $email->subject = $request->input('subject');
        $email->body = $request->input('body');
        $email->recipient = $request->input('recipient');
        $email->save();

        return response()->json(['message' => 'Email created successfully'], 201);
    }

    // Read an email
    public function read($id)
    {
        $email = Email::find($id);

        if (!$email) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        return response()->json($email, 200);
    }

    // Update an email
    public function update(Request $request, $id)
    {
        $email = Email::find($id);

        if (!$email) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        $email->subject = $request->input('subject');
        $email->body = $request->input('body');
        $email->recipient = $request->input('recipient');
        $email->save();

        return response()->json(['message' => 'Email updated successfully'], 200);
    }

    // Delete an email
    public function delete($id)
    {
        $email = Email::find($id);

        if (!$email) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        $email->delete();

        return response()->json(['message' => 'Email deleted successfully'], 200);
    }
}
