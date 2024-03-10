<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubGroup;
use App\Models\Member;
use App\Models\Group;
use Illuminate\Support\Facades\Route;
class SubGroupController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $subGroups = SubGroup::all();
        return view('admin.groups.sub-groups.index', compact('subGroups'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('admin.groups.sub-groups.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'group_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new SubGroup instance with the validated data
        $subGroup = new SubGroup();
        $subGroup->group_id = $request->input('group_id');
        $subGroup->name = $request->input('name');
        $subGroup->description = $request->input('description');
        // Add any other fields that you want to save

        // Save the SubGroup instance to the database
        $subGroup->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'SubGroup created successfully.');
    }


    // Display the specified resource.
    public function show(SubGroup $subGroup)
    {
        // Fetch members belonging to the specified subgroup
        $members = Member::where('sub_group_id', $subGroup->id)->get();

        // Count the number of members belonging to the subgroup
        $memberCount = $members->count();

        return view('admin.groups.sub-groups.show', compact('subGroup', 'members', 'memberCount'));
    }


    // Show the form for editing the specified resource.
    public function edit(SubGroup $sub_group)
    {
        $groups = Group::all();
        return view('admin.groups.sub-groups.edit', compact('sub_group','groups'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, SubGroup $subGroup)
    {
        $request->validate([
            'group_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $subGroup->update($request->all());

        $notification = array(
            'message' => 'Sub-Group updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('groups.show', ['group' => $subGroup->group_id])->with($notification);
    }


    // Remove the specified resource from storage.
    public function destroy(SubGroup $subGroup)
    {
        $subGroup->delete();

        return redirect()->route('sub_groups.index')
            ->with('success', 'SubGroup deleted successfully');
    }
}
