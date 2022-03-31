<?php
Route::group([

    'namespace' => 'ali\Front\Http\Controllers',
    'middleware' => ['web']

], function ($router) {

    $router->get('/', 'FrontController@index');

});
