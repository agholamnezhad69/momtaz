<?php

namespace ali\Ticket\Services;

use ali\Media\Services\MediaFileService;
use ali\Ticket\Models\Ticket;
use ali\Ticket\Repositories\ReplyRepo;
use ali\Ticket\Repositories\TicketRepo;
use Illuminate\Http\UploadedFile;

class ReplyService
{

    public static function store(Ticket $ticket, $reply, $attachment)
    {
        $media_id = null;
        if (isset($attachment) && ($attachment instanceof UploadedFile)) {

            $media_id = MediaFileService::privateUpload($attachment)->id;

        }
        $replyRepo = new ReplyRepo();
        $ticketRepo = new TicketRepo();
        $reply = $replyRepo->store($ticket->id, $reply, $media_id);

        if ($ticket->user_id != $reply->user_id) {

            $ticketRepo->setStatus($ticket->id, Ticket::STATUS_REPLIED);
        } else {
            $ticketRepo->setStatus($ticket->id, Ticket::STATUS_OPEN);
        }

        return $reply;

    }


}
