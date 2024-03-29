<?php

namespace ali\Discount\Providers;


use ali\Discount\Models\Discount;
use ali\Discount\Policies\DiscountPolicy;
use ali\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DiscountServiceProvider extends ServiceProvider
{
    protected $namespace = 'ali\Discount\Http\Controllers';


    public function register()
    {


        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/discount_routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(EventServiceProvider::class);
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', "Discount");
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang/");
        Gate::policy(Discount::class, DiscountPolicy::class);


    }

    public function boot()
    {


        config()->set('sidebar.items.discounts', [
            "icon" => "i-discounts",
            "title" => "تخفیف ها",
            "url" => route("discounts.index"),
            'permission' => [Permission::PERMISSION_MANAGE_DISCOUNT]
        ]);;


    }


}

