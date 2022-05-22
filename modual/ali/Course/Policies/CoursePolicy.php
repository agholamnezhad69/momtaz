<?php

namespace ali\Course\policies;

use ali\Course\Repositories\CourseRepo;
use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\True_;


class CoursePolicy
{
    use HandlesAuthorization;


    public function manage(User $user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
    }

    public function index($user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)) return true;
    }

    public function create($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)) return true;
    }

    public function edit($user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)
            && $course->teacher_id == $user->id) return true;

    }

    public function delete($user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;


    }

    public function change_confirmation_status($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
    }

    public function detail($user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)
            && $course->teacher_id == $user->id) {
            return true;
        }
    }

    public function createSeason(User $user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)
            && $course->teacher_id == $user->id) {
            return true;
        }
    }

    public function creatLesson($user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            (($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)) && ($course->teacher_id == $user->id))) {

            return true;

        }

    }

    public function download($user, $course)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            $user->id == $course->teacher_id ||
            $course->hasStudent($user->id)

        ) return true;
        return false;

    }


}
