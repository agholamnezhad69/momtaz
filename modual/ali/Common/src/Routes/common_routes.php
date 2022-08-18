<?php


Route::group([
    'namespace' => 'ali\Common\Http\Controllers',
    'middleware' => ['web', 'auth', 'verified']

], function (Illuminate\Routing\Router $router) {

    $router->get("/notifications/mark-as-read", "NotificationController@markAllAsRead")
        ->name("notifications.markAllAsRead");


});

