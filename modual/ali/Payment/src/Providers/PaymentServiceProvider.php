<?php

namespace ali\Payment\Providers;

use ali\Payment\Gateways\Gateway;
use ali\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use ali\Payment\Models\Payment;
use ali\Payment\policies\PaymentPolicy;
use ali\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    protected $namespace = 'ali\Payment\Http\Controllers';


    public function register()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/payment_routes.php');

        $this->app->register(EventServiceProvider::class);
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resourses/views', "Payment");
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resourses/Lang/');

        Gate::policy(Payment::class, PaymentPolicy::class);


    }

    public function boot()
    {

        $this->app->singleton(Gateway::class, function ($app) {

            return new ZarinpalAdaptor();

        });


        config()->set('sidebar.items.payments', [
            "icon" => "i-transactions",
            "title" => "تراکنش ها",
            "url" => route("payments.index"),
            'permission' => [Permission::PERMISSION_MANAGE_PAYMENTS]]);


    }


}

