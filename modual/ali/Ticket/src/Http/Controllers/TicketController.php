<?php

namespace ali\Ticket\Http\Controllers;

use ali\Media\Services\MediaFileService;
use ali\Ticket\Http\Requests\ReplyRequest;
use ali\Ticket\Http\Requests\TicketRequest;
use ali\Ticket\Models\Ticket;
use ali\Ticket\Repositories\ReplyRepo;
use ali\Ticket\Repositories\TicketRepo;
use ali\Ticket\Services\ReplyService;
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


        $ticket = $ticketRepo->store($ticketRequest->title);

        ReplyService::store($ticket, $ticketRequest->body, $ticketRequest->attachment);

        return redirect()->route("tickets.index");

    }


    public function reply(Ticket $ticket, ReplyRequest $replyRequest)
    {

        ReplyService::store($ticket, $replyRequest->body, $replyRequest->attachment);
        newFeedbacks();
        return redirect()->route("tickets.show", $ticket->id);

    }
}


