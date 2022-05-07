<?php

Route::group([], function ($route) {


    $route->any('payments/callback', 'PaymentController@callback')->name('payments.callback');
    $route->get('payments', [
            "uses" => "PaymentController@index",
            "as" => "payments.index"
        ]
    );

    $route->get('purchases', [
            "uses" => "PaymentController@purchases",
            "as" => "purchases.index"
        ]
    );

});
