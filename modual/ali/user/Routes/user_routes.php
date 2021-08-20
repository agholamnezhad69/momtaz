<?php

Route::group([
    'namespace' => 'ali\user\Http\Controllers',
    'middleware' => 'web',
], function () {

    Auth::routes(['verify' => true]);

});


