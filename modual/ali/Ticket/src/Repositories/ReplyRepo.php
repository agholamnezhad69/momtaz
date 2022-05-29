<?php

namespace ali\Ticket\Repositories;

use ali\Ticket\Models\Reply;
use Illuminate\Database\Eloquent\Model;

class ReplyRepo
{

    public function store($ticketId, $body, $mediaId = null): Model
    {
        return Reply::query()->create(
            [
                "user_id" => auth()->id(),
                "ticket_id" => $ticketId,
                "media_id" => $mediaId,
                "body" => $body,
            ]
        );

    }

}
