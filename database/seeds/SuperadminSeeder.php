<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperadminSeeder extends Seeder
{
    public function run()
    {
        // Retrieve the superadmin role or create it if it doesn't exist
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);

        // Retrieve the users with the specified email addresses
        $users = User::whereIn('email', ['aman@ginilytics.com', 'ben.tobias@gmail.com'])->get();

        // Assign the superadmin role to each user
        foreach ($users as $user) {
            $user->assignRole($superadminRole);
        }
    }
}
