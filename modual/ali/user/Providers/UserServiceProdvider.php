<?php


namespace ali\user\Providers;


use ali\user\Models\User;
use Illuminate\Support\ServiceProvider;

class UserServiceProdvider extends ServiceProvider
{
    public function register()
    {
      config()->set('auth.providers.users.model',User::class);
    }


    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migration');
        $this->loadFactoriesFrom(__DIR__.'/../Database/factories');
        $this->loadViewsFrom(__DIR__.'/../Resources/views','User');

    }


}
