<?php

Route::group(['middleware' => 'auth'], function ($route) {

    $route->get('/discounts', [
            'as' => 'discounts.index',
            'uses' => 'DiscountController@index'
        ]
    );

    $route->post('/discounts', [
            'as' => 'discounts.store',
            'uses' => 'DiscountController@store'
        ]
    );

    $route->delete('/discounts/{discount}', [
            'as' => 'discounts.destroy',
            'uses' => 'DiscountController@destroy'
        ]
    );

    $route->get('/discounts/{discount}/edit', [
            'as' => 'discounts.edit',
            'uses' => 'DiscountController@edit'
        ]
    );

    $route->patch('/discounts/{discount}', [
            'as' => 'discounts.update',
            'uses' => 'DiscountController@update'
        ]
    );


});
