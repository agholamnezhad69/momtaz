<?php

//Route::group([], function ($router) {
//
//    $router->resource("/comments","CommentController");
//
//
//});

Route::group([], function ($router) {

    $router->post('comments/store', [
            "uses" => "CommentController@store",
            "as" => "comments.store"
        ]
    );

    $router->get('comments', [
            "uses" => "CommentController@index",
            "as" => "comments.index"
        ]
    );

});




