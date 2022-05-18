<?php

namespace ali\Discount\Http\Controllers;


use ali\Course\Models\Course;
use ali\Course\Repositories\CourseRepo;
use App\Http\Controllers\Controller;


class DiscountController extends Controller
{

    public function index(CourseRepo $courseRepo)
    {
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);

        return view('Discount::index', compact('courses'));
    }


}
