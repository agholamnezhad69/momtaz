<?php

namespace ali\Front\Providers;


use ali\Category\Repositories\CategoryRepo;
use ali\Course\Repositories\CourseRepo;
use Carbon\Laravel\ServiceProvider;

class FrontServiceProviders extends ServiceProvider
{

    public function register()
    {

        $this->loadRoutesFrom(__DIR__ . '/../Routes/front_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views/', 'Front');


        view()->composer('Front::layout.header', function ($view) {
            $cats = (new CategoryRepo())->tree();
            $view->with(compact('cats'));
        });


        view()->composer('Front::layout.latestCourses', function ($view) {

            $latestCourses = (new CourseRepo())->latestCourses();
            $view->with(compact('latestCourses'));
        });


    }

    public function boot()
    {

    }

}
