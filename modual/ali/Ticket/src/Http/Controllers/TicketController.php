<?php

namespace ali\Ticket\Http\Controllers;

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
}


