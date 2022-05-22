<?php

namespace ali\Discount\Http\Controllers;


use ali\Common\Responses\AjaxResponses;
use ali\Course\Models\Course;
use ali\Course\Repositories\CourseRepo;
use ali\Discount\Http\Requests\DiscountRequest;
use ali\Discount\Models\Discount;
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

    public function destroy(Discount $discount)
    {

        $discount->delete();

        AjaxResponses::successResponse();


    }

    public function edit(Discount $discount, CourseRepo $courseRepo)
    {

        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view("Discount::edit", compact("discount", "courses"));


    }

    public function update(Discount $discount, DiscountRequest $discountRequest, DiscountRepo $discountRepo)
    {


        $discountRepo->update($discount->id, $discountRequest->all());
        newFeedbacks();
        return redirect()->route('discounts.index');


    }


}
