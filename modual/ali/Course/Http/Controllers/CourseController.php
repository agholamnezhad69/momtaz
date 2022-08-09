<?php

namespace ali\Course\Http\Controllers;

use ali\Category\Repositories\CategoryRepo;
use ali\Common\Responses\AjaxResponses;
use ali\Course\Http\Requests\CourseRequest;
use ali\Course\Models\Course;
use ali\Course\Repositories\CourseRepo;
use ali\Course\Repositories\LessonRepo;
use ali\Media\Services\MediaFileService;
use ali\Payment\Gateways\Gateway;
use ali\Payment\Services\PaymentService;
use ali\RolePermissions\Models\Permission;
use ali\User\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CourseController extends Controller
{


    public function index(Request $request, CourseRepo $courseRepo, CategoryRepo $categoryRepo)
    {
        $this->authorize('index', Course::class);

        if (auth()->user()->hasAnyPermission([Permission::PERMISSION_MANAGE_COURSES, Permission::PERMISSION_SUPER_ADMIN])) {

            $courses = $courseRepo
                ->joinTeacher()
                ->searchCourseTitle($request->title)
                ->searchCoursePriority($request->priority)
                ->searchCoursePrice($request->price)
                ->searchCourseTeacher($request->teacher_name)
                ->searchCategory($request->category_id)
                ->searchStatus($request->status)
                ->paginate();

        } else {

            $courses = $courseRepo
                ->joinTeacher()
                ->searchCourseTitle($request->title)
                ->searchCoursePriority($request->priority)
                ->searchCoursePrice($request->price)
                ->searchCourseTeacher($request->teacher_name)
                ->searchCategory($request->category_id)
                ->searchStatus($request->status)
                ->getCourseByTeacherId();
        }
        $categories = $categoryRepo->all();
        return view("Courses::index", compact("courses", "categories"));
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


        $this->authorize('store', [Course::class, $request->teacher_id]);
        $request->request->add(['banner_id' =>
            MediaFileService::publicUpload($request->file('image'))->id]);

        $courseRepo->store($request);

        return redirect()->route("courses.index");


    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $this->authorize('delete', Course::class);


        $course = $courseRepo->findById($id);


//        if ($course->lessons) {
//
//            foreach ($course->lessons as $lesson) {
//
//                if ($lesson->media) {
//                    $lesson->media->delete();
//                }
//            }
//
//        }

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

            $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);


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

    public function details($id, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('detail', $course);

        $lessons = $lessonRepo->paginate($id);
        return view("Courses::details", compact('course', 'lessons'));

    }

    public function buy($courseId, CourseRepo $courseRepo)
    {


        $course = $courseRepo->findById($courseId);

        if (!$this->courseCanBePurchased($course)) {
            return back();
        }

        if (!$this->authUserCanPurchaseCourse($course)) {

            return back();

        }

        [$amount, $discounts] = $course->getFinalPrice(request()->code, true);

        if ($amount <= 0) {
            $courseRepo->addStudentToCourse($course, auth()->id());
            newFeedbacks("عملیات موفق آمیز ", "شما با موفقیت در دوره ثبت نام کردید", 'success');
            return redirect($course->path());
        }


        $payment = PaymentService::generate($amount, $course, auth()->user(), $course->teacher_id, $discounts);


        resolve(Gateway::class)->redirect($payment->invoice_id);


    }

    public function courseCanBePurchased($course)
    {
        if ($course->type == Course::TYPE_FREE) {
            newFeedbacks('عملیات ناموفق', 'این دوره رایگان هست و قابلی خریداری نیست', 'error');
            return false;
        }
        if ($course->statues == Course::STATUS_LOCKED) {
            newFeedbacks('عملیات ناموفق', 'این دوره قفل هست و فعلا قابل خریداری نیست', 'error');
            return false;
        }
        if ($course->confirmation_status != Course::CONFIRMATION_STATUS_ACCEPTED) {
            newFeedbacks('عملیات ناموفق', 'این دوره هنوز تایید نشده هست', 'error');
            return false;
        }
        return true;
    }

    public function authUserCanPurchaseCourse($course)
    {
        if (auth()->id() == $course->teacher_id) {
            newFeedbacks('عملیات ناموفق', 'شما مدرس این دوره هستید', 'error');
            return false;
        }

        if (auth()->user()->can('download', $course)) {
            newFeedbacks('عملیات ناموفق', 'شما به دوره دسترسی دارید', 'error');
            return false;
        }

        return true;
    }

    public function downloadLinks($courseId, CourseRepo $courseRepo)
    {

        $course = $courseRepo->findById($courseId);

        $this->authorize('download', $course);

        return implode('<br>', $course->downloadLinks());

    }






}
