<?php

namespace ali\Comment\Providers;

use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends Serviceprovider
{

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

    }

    public function boot()
    {

    }





}
