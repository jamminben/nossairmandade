<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.user_management.roles.index',compact("roles"));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        // Create the role
        Role::create(['name' => $request->name]);

        // Redirect back or wherever you want
        return redirect()->back()->with('success', 'Role created successfully.');
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);
    
        $role = Role::findOrFail($request->id);
        $role->update(['name' => $request->name]);
    
        return redirect()->back()->with('success', 'Role updated successfully.');

    }

    public function delete(Request $request) {
        // Find the role by ID
    $role = Role::findOrFail($request->id);
    // Delete the role
    $role->delete();
    return redirect()->back()->with('success', 'Role deleted successfully.');
    
    // Return a response
    }
}
