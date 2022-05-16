<?php

namespace ali\Payment\policies;

use ali\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;


class SettlementPolicy
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
    public function index( $user)
    {

        if (
            $user->hasPermissionTo(Permission::PERMISSION_MANAGE_PAYMENTS) ||
            $user->hasPermissionTo(Permission::PERMISSION_TEACH)

        ) return true;

    }

    public function manage($user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_SETTLEMENT)) return true;

    }


    public function store($user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_TEACH)) return true;

    }


}
