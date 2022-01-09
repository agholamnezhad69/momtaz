<?php

namespace ali\Category\policies;

use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class CategoryPolicy
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

        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }


}
