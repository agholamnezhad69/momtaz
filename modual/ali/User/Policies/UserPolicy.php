<?php

namespace ali\User\Policies;

use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;


    }

    public function edit(User $user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;


    }

    public function addRole(User $user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;


    }

    public function removeRole(User $user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;


    }

    public function delete(User $user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;


    }

    public function manualVerify(User $user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_USERS)) return true;


    }
}
