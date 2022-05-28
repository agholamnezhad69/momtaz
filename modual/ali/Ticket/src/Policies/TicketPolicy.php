<?php

namespace ali\Ticket\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;


class TicketPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }
}
