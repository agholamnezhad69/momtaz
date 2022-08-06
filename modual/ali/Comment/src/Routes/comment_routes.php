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

    $router->get('comments/{comment}', [
            "uses" => "CommentController@show",
            "as" => "comments.show"
        ]
    );

    $router->patch('comments/{comment}/accept', [
            "uses" => "CommentController@accept",
            "as" => "comments.accept"
        ]
    );
    $router->patch('comments/{comment}/reject', [
            "uses" => "CommentController@reject",
            "as" => "comments.reject"
        ]
    );

});




