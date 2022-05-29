<?php

namespace ali\Ticket\Repositories;

use ali\Ticket\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketRepo
{

    public function store($title)
    {
        return Ticket::query()->create([
            "title" => $title,
            "user_id" => auth()->id()
        ]);
    }

    public function paginateAll()
    {
        return Ticket::query()->paginate();
    }

    public function findOrFailWithReplies($ticketId)
    {

        return Ticket::query()->with('ticketReplies')->findOrFail($ticketId);


    }


}
