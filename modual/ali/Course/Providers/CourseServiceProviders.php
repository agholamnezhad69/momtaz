<?php

namespace ali\Course\Providers;

use ali\Course\Models\Course;
use ali\Course\Models\Lesson;
use ali\Course\Models\Season;
use ali\Course\policies\CoursePolicy;
use ali\Course\policies\LessonPolicy;
use ali\Course\policies\SeasonPolicy;
use ali\RolePermissions\Models\Permission;
use Illuminate\Support\Facades\Gate;
use  Illuminate\Support\ServiceProvider;

class CourseServiceProviders extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . "/../Routes/courses_routes.php");
        $this->loadRoutesFrom(__DIR__ . "/../Routes/season_routes.php");
        $this->loadRoutesFrom(__DIR__ . "/../Routes/lesson_routes.php");
        $this->loadViewsFrom(__DIR__ . '/../Resources/views/', 'Courses');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang/");
        $this->loadTranslationsFrom(__DIR__ . "/../Resources/Lang/", "Courses");
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Season::class, SeasonPolicy::class);
        Gate::policy(Lesson::class, LessonPolicy::class);


    }

    public function boot()
    {

        config()->set('sidebar.items.courses', [
            "icon" => "i-courses",
            "title" => "دوره ها",
            "url" => route("courses.index"),
            'permission' => [Permission::PERMISSION_MANAGE_COURSES,Permission::PERMISSION_MANAGE_OWN_COURSES]]);
    }


}
