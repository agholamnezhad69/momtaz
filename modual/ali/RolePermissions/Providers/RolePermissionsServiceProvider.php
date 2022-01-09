<?php

namespace ali\RolePermissions\Providers;


use ali\RolePermissions\Database\seeds\RolePermissionTableSeeder;
use ali\RolePermissions\Models\Permission;
use ali\RolePermissions\Models\Role;
use ali\RolePermissions\Policies\RolePermissionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class RolePermissionsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'RolePermissions');
        $this->loadRoutesFrom(__DIR__ . "/../Routes/role_permissions_routes.php");
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");
        \DatabaseSeeder::$seeders[] = RolePermissionTableSeeder::class;

        Gate::policy(Role::class, RolePermissionPolicy::class);
        Gate::before(function ($user) {
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
        });

    }

    public function boot()
    {
        config()->set('sidebar.items.role-permissions', [
            "icon" => "i-role-permissions",
            "title" => "نقش های کاربری",
            "url" => route("role-permissions.index")
        ]);
    }

}
