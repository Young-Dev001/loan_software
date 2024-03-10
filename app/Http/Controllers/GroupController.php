<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Group;
use App\Models\Member;
use App\Models\SubGroup;
class GroupController extends Controller
{
    //
    public function index()
    {
        $groups = Group::latest()->get();
        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Group::create($request->all());
        $notification = array(
            'message' => 'Group created successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('groups.index')->with($notification);
    }

    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function show(Group $group)
    {
        // Retrieve the sub_groups related to the selected group
        $sub_groups = Subgroup::where('group_id', $group->id)->get();

        // Retrieve all groups to pass them to the view
        $groups = Group::all();

        return view('admin.groups.show', compact('group', 'sub_groups', 'groups'));
    }




    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $group->update($request->all());
        $notification = array(
            'message' => 'Group updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('groups.index')->with($notification);
    }

    public function destroy(Group $group)
    {
        $group->delete();
        $notification = array(
            'message' => 'Group deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('groups.index')->with($notification);
    }
}
