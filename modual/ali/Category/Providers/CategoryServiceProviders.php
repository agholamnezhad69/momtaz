<?php

namespace ali\Category\Providers;

use ali\Category\Models\Category;
use ali\Category\policies\CategoryPolicy;
use ali\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProviders extends ServiceProvider
{
    public function register()
    {

        $this->loadRoutesFrom(__DIR__ . "/../Routes/category_routes.php");
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'Categories');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations/2021_08_30_033033_create_categories_table.php');
        Gate::policy(Category::class, CategoryPolicy::class);
    }

    public function boot()
    {

        config()->set('sidebar.items.categories', [
            "icon" => "i-categories",
            "title" => "دسته بندی ها",
            "url" => route("categories.index"),
            'permission' => Permission::PERMISSION_MANAGE_CATEGORIES
        ]);


    }

}
