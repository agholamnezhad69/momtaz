<?php
Route::group(["middleware" => "auth"], function ($router) {

    $router->get("settlements",
        [
            "as" => "settlements.index",
            "uses" => "SettlementController@index"
        ]);

      $router->post("settlements",
        [
            "as" => "settlements.store",
            "uses" => "SettlementController@store"
        ]);

    $router->get("settlements/create",
        [
            "as" => "settlements.create",
            "uses" => "SettlementController@create"
        ]);


});
