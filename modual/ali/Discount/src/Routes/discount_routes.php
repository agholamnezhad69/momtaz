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



});
