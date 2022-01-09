<?php
Route::group([

    'namespace' => 'ali\Category\Http\Controllers',
    'middleware' => ['web', 'auth', 'verified']

], function ($router) {

    $router->resource('categories', 'CategoryController');



});




