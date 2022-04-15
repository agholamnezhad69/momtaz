<?php

namespace ali\Front\Http\Controllers;

use ali\Course\Repositories\CourseRepo;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;


class FrontController extends Controller
{

    public function index()
    {
        return view('Front::index');
    }

    public function singleCourse($slug, CourseRepo $courseRepo)
    {

        $course_id = Str::before(Str::after($slug, 'c-'), '-');
        $course = $courseRepo->findById($course_id);

        return view('Front::singleCourse', compact('course'));

    }

}
