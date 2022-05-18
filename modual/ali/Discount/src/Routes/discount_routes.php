<?php

Route::group(['middleware' => 'auth'], function ($route) {

    $route->get('/discounts', [
            'as' => 'discounts.index',
            'uses' => 'DiscountController@index'
        ]
    );

});
