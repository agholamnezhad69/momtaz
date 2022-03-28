<?php

namespace ali\Course\policies;

use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\True_;


class LessonPolicy
{
    use HandlesAuthorization;


    public function edit($user, $lesson)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            (($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)) && ($lesson->course->teacher_id == $user->id)))
            return true;
    }

    public function delete($user, $lesson)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            (($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES))
                && ($lesson->course->teacher_id == $user->id)))
            return true;




    }




}
