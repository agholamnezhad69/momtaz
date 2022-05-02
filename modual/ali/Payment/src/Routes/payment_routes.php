<?php

Route::group([], function ($route) {


    $route->any('payments/callback','PaymentController@callback')->name('payments.callback');

});
