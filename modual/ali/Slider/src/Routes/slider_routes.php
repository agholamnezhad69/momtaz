<?php
Route::group([], function ($router){
    $router->resource("slides", "SlideController");
});
