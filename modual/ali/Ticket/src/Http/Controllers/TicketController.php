<?php

namespace ali\Ticket\Http\Controllers;

use ali\Common\Responses\AjaxResponses;
use ali\Media\Services\MediaFileService;
use ali\RolePermissions\Models\Permission;
use ali\Ticket\Http\Requests\ReplyRequest;
use ali\Ticket\Http\Requests\TicketRequest;
use ali\Ticket\Models\Reply;
use ali\Ticket\Models\Ticket;
use ali\Ticket\Repositories\ReplyRepo;
use ali\Ticket\Repositories\TicketRepo;
use ali\Ticket\Services\ReplyService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\UploadedFile;

class TicketController extends Controller
{

    public function index(TicketRepo $ticketRepo, Request $request)
    {

        if (auth()->user()->can(Permission::PERMISSION_MANAGE_TICKETS)) {
            $tickets = $ticketRepo
                ->joinUsers()
                ->searchEmail($request->email)
                ->searchName($request->name)
                ->searchTitle($request->title)
                ->searchDate($request->date)
                ->searchStatus($request->status)
                ->paginate();
        } else {
            $tickets = $ticketRepo->paginateAll(auth()->id());
        }
        return view("Tickets::index", compact("tickets"));
    }

    public function create()
    {

        return view("Tickets::create");

    }

    public function show($ticketId, TicketRepo $ticketRepo)
    {
        $ticket = $ticketRepo->findOrFailWithReplies($ticketId);
        $this->authorize("show", $ticket);


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

        $this->authorize("show", $ticket);
        ReplyService::store($ticket, $replyRequest->body, $replyRequest->attachment);
        newFeedbacks();
        return redirect()->route("tickets.show", $ticket->id);

    }

    public function close(Ticket $ticket, TicketRepo $ticketRepo)
    {

        $this->authorize("show", $ticket);
        $ticketRepo->setStatus($ticket->id, Ticket::STATUS_CLOSE);
        newFeedbacks();
        return redirect()->route("tickets.index");


    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $hasAttachment = Reply::query()
            ->where('ticket_id', $ticket->id)
            ->whereNotNull("media_id")
            ->get();

        foreach ($hasAttachment as $reply) {
            $reply->media->delete();
        }

        $ticket->delete();
        return AjaxResponses::SuccessResponse();


    }
}


