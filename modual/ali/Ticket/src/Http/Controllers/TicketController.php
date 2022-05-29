<?php

namespace ali\Ticket\Http\Controllers;

use ali\Ticket\Http\Requests\TicketRequest;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{

    public function index()
    {
        dd("index");
    }

    public function create()
    {

        return view("Tickets::create");

    }

    public function store(TicketRequest $ticketRequest)
    {

        dd($ticketRequest->all());

    }
}


