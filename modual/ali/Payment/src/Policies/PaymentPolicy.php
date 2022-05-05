<?php

namespace ali\Payment\policies;

use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class PaymentPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    public function manage(User $user)
    {


        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_PAYMENTS)) return true;

    }


}
