<?php

namespace ali\RolePermissions\Database\seeds;

use ali\RolePermissions\Models\Permission;
use ali\RolePermissions\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{

    public function run()
    {
        foreach (Permission::$permissions as $permission) {

            Permission::findOrCreate($permission);
        }

        foreach (Role::$roles as $name => $permissions) {

            Role::findOrCreate($name)->givePermissionTo($permissions);
        }


    }
}
