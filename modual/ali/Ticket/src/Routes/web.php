<?php

Route::group([

    'middleware' => ['web', 'auth', 'verified']

], function ($route) {


    $route->resource("tickets", "TicketController");
    $route->post("tickets/{ticket}/reply", "TicketController@reply")->name("tickets.reply");
    $route->get("tickets/{ticket}/close", "TicketController@close")->name("tickets.close");

});
