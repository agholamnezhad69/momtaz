<?php
Route::group(
    [ 'middleware' => ['web', 'auth', 'verified']],

    function ($router) {

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

    $router->get("settlements/{settlement}/edit",
        [
            "as" => "settlements.edit",
            "uses" => "SettlementController@edit"
        ]);


    $router->patch("settlements/{settlement}",
        [
            "as" => "settlements.update",
            "uses" => "SettlementController@update"
        ]);


});
