<?php
Route::group(["middleware" => "auth"], function ($router) {

    $router->get("settlements/create",
        [
            "as" => "settlements.create",
            "uses" => "SettlementController@create"
        ]);

    $router->post("settlements",
        [
            "as" => "settlements.store",
            "uses" => "SettlementController@store"
        ]);

});
