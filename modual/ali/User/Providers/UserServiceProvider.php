<?php


namespace ali\User\Providers;



use ali\User\Database\seeds\UserTableSeeder;
use ali\User\Models\User;
use ali\User\Policies\UserPolicy;
use ali\User\Http\Middleware\StoreUserIp;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migration');
        $this->loadFactoriesFrom(__DIR__.'/../Database/factories');
        $this->loadViewsFrom(__DIR__.'/../Resources/views','User');
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang/");
        \DatabaseSeeder::$seeders[] = UserTableSeeder::class;
        $this->app['router']->pushMiddlewareToGroup('web', StoreUserIp::class);
        Gate::policy(User::class,UserPolicy::class);
    }


    public function boot()
    {

        config()->set('auth.providers.users.model',User::class);

        config()->set('sidebar.items.users', [
            "icon" => "i-users",
            "title" => "کاربران",
            "url" => route("users.index")
        ]);

    }


}
