<?php

namespace ali\Discount\Http\Controllers;


use ali\Course\Models\Course;
use ali\Course\Repositories\CourseRepo;
use ali\Discount\Http\Requests\DiscountRequest;
use ali\Discount\Repositories\DiscountRepo;
use App\Http\Controllers\Controller;


class DiscountController extends Controller
{

    public function index(CourseRepo $courseRepo, DiscountRepo $discountRepo)
    {
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        $discounts = $discountRepo->paginateAll();
        return view('Discount::index', compact('courses', 'discounts'));
    }

    public function store(DiscountRequest $discountRequest, DiscountRepo $discountRepo)
    {

        $discountRepo->Store($discountRequest->all());

        newFeedbacks();

        return back();


    }


}
