<?php

namespace ali\Ticket\Http\Controllers;

use ali\Media\Services\MediaFileService;
use ali\Ticket\Http\Requests\TicketRequest;
use ali\Ticket\Repositories\ReplyRepo;
use ali\Ticket\Repositories\TicketRepo;
use App\Http\Controllers\Controller;

use Illuminate\Http\UploadedFile;

class TicketController extends Controller
{

    public function index(TicketRepo $ticketRepo)
    {
        $tickets = $ticketRepo->paginateAll();
        return view("Tickets::index", compact("tickets"));
    }

    public function create()
    {

        return view("Tickets::create");

    }

    public function show($ticketId, TicketRepo $ticketRepo)
    {

        $ticket = $ticketRepo->findOrFailWithReplies($ticketId);

        return view("Tickets::show", compact('ticket'));


    }

    public function store(TicketRequest $ticketRequest, TicketRepo $ticketRepo)
    {

        $media_id = null;
        if (isset($ticketRequest->attachment) && ($ticketRequest->attachment instanceof UploadedFile)) {

            $media_id = MediaFileService::privateUpload($ticketRequest->attachment)->id;

        }

        $ticket = $ticketRepo->store($ticketRequest->title);

        $replyRepo = new ReplyRepo();

        $replyRepo->store($ticket->id, $ticketRequest->body, $media_id);

        newFeedbacks();

        return redirect()->route("tickets.index");


    }
}


