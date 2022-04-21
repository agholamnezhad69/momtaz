<?php

namespace ali\Media\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MediaServiceProviders extends ServiceProvider
{
    protected $namespace = 'ali\Media\Http\Controllers';

    public function register()
    {

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/media_routes.php');


        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../Config/mediaFile.php', 'mediaFile');


    }

    public function boot()
    {

    }

}
