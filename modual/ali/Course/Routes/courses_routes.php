<?php
Route::group([

    'namespace' => 'ali\Course\Http\Controllers',
    'middleware' => ['web', 'auth', 'verified']

], function ($router) {


    $router->patch('courses/{course}/accept', 'CourseController@accept')->name('courses.accept');
    $router->patch('courses/{course}/reject', 'CourseController@reject')->name('courses.reject');
    $router->patch('courses/{course}/lock', 'CourseController@lock')->name('courses.lock');
    $router->resource('courses', 'CourseController');

});

