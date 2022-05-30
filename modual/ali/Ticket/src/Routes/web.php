<?php

Route::group(["middleware" => "auth"], function ($route) {

    $route->resource("tickets", "TicketController");
    $route->post("tickets/{ticket}/reply", "TicketController@reply")->name("tickets.reply");

});
