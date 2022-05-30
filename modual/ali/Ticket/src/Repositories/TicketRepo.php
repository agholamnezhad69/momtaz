<?php

namespace ali\Ticket\Repositories;

use ali\Ticket\Models\Ticket;


class TicketRepo
{

    public function store($title)
    {
        return Ticket::query()->create([
            "title" => $title,
            "user_id" => auth()->id()
        ]);
    }

    public function paginateAll($userId = null)
    {
        $query = Ticket::query();
        if ($userId)
            $query->where('user_id', $userId);

        return $query->latest()->paginate();
    }

    public function findOrFailWithReplies($ticketId)
    {

        return Ticket::query()->with('ticketReplies')->findOrFail($ticketId);


    }

    public function setStatus($ticketId, $status)
    {
        return Ticket::query()->where('id', $ticketId)->update([
            "status" => $status
        ]);

    }


}
