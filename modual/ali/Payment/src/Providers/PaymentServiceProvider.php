<?php

namespace ali\Payment\Providers;

use ali\Payment\Gateways\Gateway;
use ali\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use ali\Payment\Models\Payment;
use ali\Payment\Models\Settlement;
use ali\Payment\policies\PaymentPolicy;
use ali\Payment\policies\SettlementPolicy;
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

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/settlement_routes.php');

        $this->app->register(EventServiceProvider::class);
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resourses/views', "Payment");
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resourses/Lang/');

        Gate::policy(Payment::class, PaymentPolicy::class);
        Gate::policy(Settlement::class, SettlementPolicy::class);


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
            'permission' => [Permission::PERMISSION_MANAGE_PAYMENTS]
        ]);


        config()->set('sidebar.items.my-purchases', [
            "icon" => "i-my__purchases",
            "title" => "خرید های من",
            "url" => route("purchases.index"),
        ]);

        config()->set('sidebar.items.settlementsRequest', [
            "icon" => "i-checkout__request",
            "title" => "درخواست تسویه حساب",
            "url" => route("settlements.create"),
            'permission' => [
                Permission::PERMISSION_TEACH
            ]
        ]);

        config()->set('sidebar.items.settlements', [
            "icon" => "i-checkouts",
            "title" => "تسویه حساب ها",
            "url" => route("settlements.index"),
            'permission' => [
                Permission::PERMISSION_MANAGE_SETTLEMENT,
                Permission::PERMISSION_TEACH
            ]

        ]);


    }


}

