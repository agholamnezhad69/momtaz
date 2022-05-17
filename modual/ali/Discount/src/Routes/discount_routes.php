<?php

Route::group(['middleware' => 'auth'], function ($route) {

    $route->get('discounts/', [
            'as' => 'DiscountController@index',
            'uses' => 'discounts.index'
        ]
    );

});
