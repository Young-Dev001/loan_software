<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Group;
use App\Models\SubGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Add this line for the Storage facade
use Illuminate\Support\Facades\File;
class MemberController extends Controller
{
    // Display a listing of the members.
    public function index()
    {
        $members = Member::latest()->get();
        return view('admin.members.index', compact('members'));
    }

    // Show the form for creating a new member.
    public function create()
    {
        $subgroups = SubGroup::all();
        return view('admin.members.create', compact('subgroups'));
    }

    // Store a newly created member in the database.

    public function store(Request $request)
    {
        // Ensure the authenticated user ID is fetched correctly
        $userId = Auth::id();

        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:255', 'regex:/^\+254[17]\d{8}$/'],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sub_group_id' => 'required',
            'residence' => 'required|string|max:255',
            'postal_address' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'password' => 'required|string|min:4|confirmed',
            'registration_fee' => 'required|numeric|min:1',
            'registration_date' => 'required|date',
        ], [
            'phone.regex' => 'The phone number must be in the format +2547... or +2541...',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/member_images'), $filename);
        }

        // Create a new member instance
        $member = new Member;
        $member->name = $validatedData['name'];
        $member->id_number = $validatedData['id_number'];
        $member->phone = $validatedData['phone'];
        $member->photo = isset($filename) ? $filename : null;
        $member->sub_group_id = $validatedData['sub_group_id'];
        $member->residence = $validatedData['residence'];
        $member->postal_address = $validatedData['postal_address'];
        $member->town = $validatedData['town'];
        $member->email = $validatedData['email'];
        $member->password = bcrypt($validatedData['password']);
        $member->registration_fee = $validatedData['registration_fee'];
        $member->registration_date = $validatedData['registration_date'];

        // Save the member data
        $member->save();

        $notification = [
            'message' => 'Member registered successfully!',
            'alert-type' => 'success'
        ];

        // Redirect to the members index page with a success message
        return redirect()->route('members.index')->with($notification);
    }
    public function edit(Member $member)
    {
        $subgroups = SubGroup::all();
        return view('admin.members.edit', compact('member','subgroups'));
    }

    // Update the specified member in the database.
// Update the specified member in the database.
public function update(Request $request, $id)
{
    // Retrieve the member instance from the database
    $member = Member::findOrFail($id);

    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'id_number' => 'required|string|max:255',
        'phone' => ['required', 'string', 'max:255', 'regex:/^\+254[17]\d{8}$/'],
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust image validation as needed
        'residence' => 'required|string|max:255',
        'sub_group_id' => 'required',
        'postal_address' => 'required|string|max:255',
        'town' => 'required|string|max:255',
        'email' => 'required|email|unique:members,email,'.$member->id,
        'registration_fee' => 'required|numeric|min:1',
        'registration_date' => 'required|date',
    ], [
        'phone.regex' => 'The phone number must be in the format +2547... or +2541...',
    ]);

    // Update the member's information
    $member->fill($validatedData);

    // Check if a new photo was uploaded
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');

        // Delete the old photo if it exists
        if ($member->photo) {
            @unlink(public_path('upload/member_images/' . $member->photo));
        }

        $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
        $file->move(public_path('upload/member_images'), $filename);

        // Update member's photo field
        $member->photo = $filename;
    }


    // Save the updated member information
    $member->phone = $validatedData['phone'];
    $member->residence = $validatedData['residence'];
    $member->registration_fee = $validatedData['registration_fee'];
    $member->registration_date = $validatedData['registration_date'];
    $member->sub_group_id = $validatedData['sub_group_id'];
    $member->save();

    $notification = [
        'message' => 'Member updated successfully!',
        'alert-type' => 'success'
    ];

    // Redirect back to the members index page with a success message
    return redirect()->route('members.index')->with($notification);
}


public function profile_Update(Request $request, $id)
{
    $member = Member::findOrFail($id);
    $id = Auth::user()->id;
    $originalData = $member->toArray(); // Store the original data for comparison later

    // Check if the authenticated user is trying to update their own profile
    if ($member->id !== $id) {
        // Handle unauthorized access here, perhaps return a response indicating the unauthorized action.
    }

    // Validate the incoming request data for file upload
    $request->validate([
        'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules for image files
    ]);

    // Check if there's a photo uploaded
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');

        // Delete the old photo if it exists
        if ($member->photo) {
            @unlink(public_path('upload/member_images/' . $member->photo));
        }

        $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
        $file->move(public_path('upload/member_images'), $filename);

        // Update member's photo field
        $member->photo = $filename;
        $member->save();

        // Set notification for photo update
        $notification = [
            'message' => 'Profile picture updated successfully!',
            'alert-type' => 'success'
        ];
    } else {
        // Set notification for no photo uploaded
        $notification = [
            'message' => 'No photo uploaded!',
            'alert-type' => 'error'
        ];
    }

    // Redirect back to the members edit page with the appropriate notification message
    return redirect()->route('members.show', ['member' => $member->id])->with($notification);
}


public function Password_Update(Request $request, $id)
{
    $member = Member::findOrFail($id);
    $id = Auth::user()->id;
    $data = Member::find($id);
    $originalData = $data->toArray(); // Store the original data for comparison later

    // Validate the incoming request data for password update
    $validatedData = $request->validate([
        'oldpassword' => 'required|string',
        'newpassword' => 'required|string|min:4|confirmed',
    ]);

    // Verify the old password
    if (!Hash::check($validatedData['oldpassword'], $member->password)) {
        return back()->withErrors(['oldpassword' => 'The old password is incorrect.'])->withInput();
    }

    // Update the member's password with the new one
    $member->password = Hash::make($validatedData['newpassword']);

    // Save the updated password
    $member->save();

    // Check if there's a photo uploaded
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        // Delete the old photo if it exists
        if ($data->photo) {
            @unlink(public_path('upload/member_images/' . $data->photo));
        }
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('upload/member_images'), $filename);
        $data->photo = $filename; // update image field
        $data->save(); // Save the member data with updated photo

        // Set notification for photo update
        $notification = [
            'message' => 'Profile picture updated successfully!',
            'alert-type' => 'success'
        ];
    } else {
        // Set default notification for password update
        $notification = [
            'message' => 'Password updated successfully!',
            'alert-type' => 'success'
        ];
    }

    // Redirect back to the members edit page with the appropriate notification message
    return redirect()->route('members.show', ['member' => $member->id])->with($notification);
}


    public function show(Member $member)
{
    $id = Auth::user()->id;
    $memberData = Member::find($id);
    return view('admin.members.show', compact('member','memberData'));
}

    // Remove the specified member from the database.
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        // Delete the member's photo if it exists
        if ($member->photo) {
            $photoPath = public_path('upload/member_images/' . $member->photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        // Delete the member
        $member->delete();

        $notification = [
            'message' => 'Member deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('members.index')->with($notification);
    }
}
