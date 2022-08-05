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
    $router->delete('comments/{comment}/delete', [
            "uses" => "CommentController@destroy",
            "as" => "comments.destroy"
        ]
    );

    $router->get('comments', [
            "uses" => "CommentController@index",
            "as" => "comments.index"
        ]
    );

});




