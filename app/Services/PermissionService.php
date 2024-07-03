<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    function createPermission($name, $group, $page)
    {
        // Check if permission already exists
        if (!Permission::where('name', $name)->exists()) {
            Permission::create([
                'name' => $name,
                'pages' => $page,
                'group' => $group,
            ]);
        }
    }
}
