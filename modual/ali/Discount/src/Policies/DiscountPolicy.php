<?php

namespace ali\Discount\Policies;


use ali\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;


class DiscountPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function manage($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_DISCOUNT)) return true;
    }
}
