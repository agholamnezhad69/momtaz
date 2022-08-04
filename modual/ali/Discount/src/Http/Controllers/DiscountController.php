<?php

namespace ali\Discount\Http\Controllers;


use ali\Common\Responses\AjaxResponses;
use ali\Course\Models\Course;
use ali\Course\Repositories\CourseRepo;
use ali\Discount\Http\Requests\DiscountRequest;
use ali\Discount\Models\Discount;
use ali\Discount\Repositories\DiscountRepo;
use ali\Discount\Services\DiscountService;
use App\Http\Controllers\Controller;


class DiscountController extends Controller
{

    public function index(CourseRepo $courseRepo, DiscountRepo $discountRepo)
    {
        $this->authorize('manage', Discount::class);
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        $discounts = $discountRepo->paginateAll();
        return view('Discount::index', compact('courses', 'discounts'));
    }

    public function store(DiscountRequest $discountRequest, DiscountRepo $discountRepo)
    {
        $this->authorize('manage', Discount::class);

        $discountRepo->Store($discountRequest->all());

        newFeedbacks();

        return back();

    }

    public function destroy(Discount $discount)
    {
        $this->authorize('manage', Discount::class);

        $discount->delete();

        AjaxResponses::successResponse();


    }

    public function edit(Discount $discount, CourseRepo $courseRepo)
    {
        $this->authorize('manage', Discount::class);
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view("Discount::edit", compact("discount", "courses"));


    }

    public function update(Discount $discount, DiscountRequest $discountRequest, DiscountRepo $discountRepo)
    {

        $this->authorize('manage', Discount::class);
        $discountRepo->update($discount->id, $discountRequest->all());
        newFeedbacks();
        return redirect()->route('discounts.index');


    }

    public function check($code, Course $course, DiscountRepo $discountRepo)
    {
        $discount = $discountRepo->getValidDiscountByCode($code, $course->id);
        if ($discount) {
            $discountAmount = DiscountService::calculateDiscountAmount($course->getFinalPrice(), $discount->percent);
            $response = [
                "status" => "valid",
                "payableAmount" => $course->getFinalPrice() - $discountAmount,
                "discountAmount" => $discountAmount,
                "discountPercent" => $discount->percent
            ];

            return response()->json($response);

        }
        return response()->json([
            "status" => "invalid"
        ], 422);

    }


}
