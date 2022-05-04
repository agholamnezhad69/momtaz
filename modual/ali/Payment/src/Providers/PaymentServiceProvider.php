<?php

namespace ali\Payment\Providers;

use ali\Payment\Gateways\Gateway;
use ali\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    protected $namespace = 'ali\Payment\Http\Controllers';


    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/payment_routes.php');

    }

    public function boot()
    {

        $this->app->singleton(Gateway::class, function ($app) {

            return new ZarinpalAdaptor();

        });


    }


}

