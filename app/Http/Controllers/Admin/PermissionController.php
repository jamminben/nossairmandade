<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Constants\Constants;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function index(Request $request) {
        $permissions = Permission::all();    
        $pages = Permission::distinct('pages')->pluck('pages');    
        return view('admin.user_management.permissions.index', ['permissions' => $permissions, 'pages' => $pages]);
    }

    public function assignPermissionsToUser(Request $request) {
        $user = User::where('id',$request->userId)->first();
        $permissions = Permission::where('pages', Constants::PAGE_HINARIO)->get()->groupBy('group')->sortBy(function ($group, $key) {
            return $key;
        });
        return view('admin.user_management.permissions.assignPermission',['permissions'=>$permissions, 'user' => $user]);
    }

    public function assignPermissions(Request $request) {
        $user = User::where('id',$request->userId)->first();
        foreach($request->permissions as $name => $value) {
            if ($value == Constants::HINARIO_CHECKBOX_ACTIVE_STATE) {
                $user->givePermissionTo($name);
            } else {
                $user->revokePermissionTo($name);
            }
        }
        return redirect()->route('users.index')->with('success', 'Permissions updated successfully.');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'page' => 'required|string|max:255'
        ]);

        // Create a new permission instance
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->pages = $request->page;

        // Save the permission
        $permission->save();

        // Redirect the user back with a success message
        return redirect()->back()->with('success', 'Permission created successfully.');

    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $request->id,
            'page' => 'required|string|max:255'
        ]);

        $permission = Permission::findOrFail($request->id);
        $permission->name = $request->name;
        $permission->pages = $request->page;
        $permission->save();

        return redirect()->back()->with('success', 'Permission updated successfully.');

    }

    public function delete(Request $request) {
        $permission = Permission::findOrFail($request->id);
        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully.');
    }
}
