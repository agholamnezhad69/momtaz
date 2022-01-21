<?php

namespace ali\Course\policies;

use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\True_;


class SeasonPolicy
{
    use HandlesAuthorization;


    public function edit($user, $season)
    {


        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)
            && $season->course->teacher_id == $user->id;


    }

    public function change_confirmation_status($user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return null;
    }

    public function delete($user, $season)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)
            && $season->course->teacher_id == $user->id) {
            return true;
        }
    }


}
