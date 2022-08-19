<?php

namespace ali\Front\Providers;


use ali\Category\Repositories\CategoryRepo;
use ali\Course\Repositories\CourseRepo;
use ali\Slider\Repositories\SlideRepo;
use Illuminate\Support\ServiceProvider;


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

        view()->composer('Front::layout.slider', function ($view) {
            $slides = (new SlideRepo())->all();
            $view->with(compact('slides'));
        });


    }

    public function boot()
    {

    }

}
