<?php

Route::group(["middleware" => "auth"], function ($route) {

    $route->resource("tickets", "TicketController");

});
