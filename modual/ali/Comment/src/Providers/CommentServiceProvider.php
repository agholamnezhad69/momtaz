<?php

namespace ali\Comment\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends Serviceprovider
{

    protected $namespace = 'ali\Comment\Http\Controllers';

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', "Comment");

        Route::middleware(['web', 'auth','verified'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/comment_routes.php');

    }

    public function boot()
    {

    }


}
