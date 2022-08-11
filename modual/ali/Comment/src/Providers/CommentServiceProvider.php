<?php

namespace ali\Comment\Providers;

use ali\Comment\Models\Comment;
use ali\Comment\Policies\CommentPolicy;
use ali\Comment\Providers\EventServiceProvider;
use ali\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends Serviceprovider
{

    protected $namespace = 'ali\Comment\Http\Controllers';

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', "Comment");
        $this->loadJsonTranslationsFrom(__DIR__ . '/../Resources/Lang/');
        $this->app->register(EventServiceProvider::class);
        Route::middleware(['web', 'auth', 'verified'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/comment_routes.php');

        Gate::policy(Comment::class, CommentPolicy::class);

    }

    public function boot()
    {
        config()->set('sidebar.items.comments', [
            "icon" => "i-comments",
            "title" => "نظرات",
            "url" => route("comments.index"),
            'permission' => [Permission::PERMISSION_MANAGE_COMMENTS, Permission::PERMISSION_TEACH]
        ]);
    }


}
