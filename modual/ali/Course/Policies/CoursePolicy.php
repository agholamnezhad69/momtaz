<?php

namespace ali\Course\policies;

use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use phpDocumentor\Reflection\Types\True_;


class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user)
    {

        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    public function create($user)
    {

        return
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
    }

    public function edit($user, $course)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES)
            && $course->teacher_id == $user->id;


    }

    public function delete($user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return null;

    }

    public function change_confirmation_status($user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return null;
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


}
