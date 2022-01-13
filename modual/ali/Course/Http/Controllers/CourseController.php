<?php

namespace ali\Course\Http\Controllers;

use ali\Category\Repositories\CategoryRepo;
use ali\Common\Responses\AjaxResponses;
use ali\Course\Http\Requests\CourseRequest;
use ali\Course\Models\Course;
use ali\Course\Repositories\CourseRepo;

use ali\Media\Services\MediaFileService;
use ali\User\Http\Requests\UpdateUserRequest;
use ali\User\Repositories\UserRepo;
use App\Http\Controllers\Controller;


class CourseController extends Controller
{


    public function index(CourseRepo $courseRepo)
    {
        $this->authorize('manage', Course::class);
        $courses = $courseRepo->paginate();
        return view("Courses::index", compact("courses"));
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $this->authorize('create', Course::class);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view("Courses::create",
            compact("teachers", "categories"));

    }
    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {
        $request->request->add(['banner_id' => MediaFileService::upload($request->file('image'))->id]);
        $courseRepo->store($request);

        return redirect()->route("courses.index");


    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $this->authorize('delete', Course::class);
        $course = $courseRepo->findById($id);
        if ($course->banner) {
            $course->banner->delete();
        }
        $course->delete();
        return AjaxResponses::successResponse();

    }

    public function edit($id, UserRepo $userRepo, CategoryRepo $categoryRepo, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('edit', $course);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view("Courses::edit", compact("teachers", "categories", "course"));


    }

    public function update($id, CourseRequest $request, CourseRepo $courseRepo)
    {

        $course = $courseRepo->findById($id);
        $this->authorize('edit', $course);
        if ($request->hasFile('image')) {

            $request->request->add(['banner_id' => MediaFileService::upload($request->file('image'))->id]);


            if ($course->banner) {

                $course->banner->delete();

            }


        } else {
            $request->request->add(['banner_id' => $course->banner_id]);
        }

        $courseRepo->update($id, $request);

        return redirect(route("courses.index"));

    }

    public function accept($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);

        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_ACCEPTED)) {

            return AjaxResponses::successResponse();

        }

        return AjaxResponses::failResponse();
    }

    public function reject($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);

        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_REJECTED)) {

            return AjaxResponses::successResponse();

        }

        return AjaxResponses::failResponse();
    }

    public function lock($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);

        if ($courseRepo->updateStatus($id, Course::STATUS_LOCKED)) {

            return AjaxResponses::successResponse();

        }

        return AjaxResponses::failResponse();
    }

    public function show()
    {
        return abort(404);
    }

}
