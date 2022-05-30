<?php

namespace ali\Ticket\Policies;

use ali\RolePermissions\Models\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;


class TicketPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    public function show($user, $ticket)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_TICKETS) ||
            $ticket->user_id == $user->id)
            return true;

    }

    public function delete($user)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_TICKETS)) return true;

    }
}
