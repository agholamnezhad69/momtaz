<?php

namespace ali\Comment\Policies;

use ali\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index($user)
    {


        if ($user->hasAnyPermission(Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_TEACH))
            return true;

        return null;

    }


    public function view($user, $comment)
    {


        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS) ||
            ($user->hasPermissionTo(Permission::PERMISSION_TEACH) && $comment->commentable->teacher_id == auth()->id()))
            return true;

        return null;

    }

    public function manage($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS)) return true;
        return null;
    }

    public function replies($user, $comment)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ||
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COMMENTS) ||
            ($user->hasPermissionTo(Permission::PERMISSION_TEACH) && $comment->commentable->teacher_id == auth()->id())) {

            return true;
        }


        return null;
    }


}
