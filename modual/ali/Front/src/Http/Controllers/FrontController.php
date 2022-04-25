<?php

namespace ali\Front\Http\Controllers;

use ali\Course\Repositories\CourseRepo;
use ali\Course\Repositories\LessonRepo;
use ali\RolePermissions\Models\Permission;
use ali\User\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;


class FrontController extends Controller
{

    public function index()
    {
        return view('Front::index');
    }

    public function singleCourse($slug, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {

        $course_id = $this->extractId($slug, 'c');
        $course = $courseRepo->findById($course_id);
        $lessons = $lessonRepo->getAcceptedLessons($course_id);


        if (request()->lesson) {

            $lessonId = $this->extractId(request()->lesson, 'l');
            $lesson = $lessonRepo->getLesson($lessonId, $course_id);

        } else {
            $lesson = $lessonRepo->getFirstLesson($course_id);
        }

        return view('Front::singleCourse', compact('course', 'lessons', 'lesson'));

    }

    public function extractId($slug, $key)
    {
        return Str::before(Str::after($slug, $key . '-'), '-');
    }

    public function singleTutor($username)
    {


        $teacher = User::permission(Permission::PERMISSION_TEACH)->where('username', $username)->first();

        return view("Front::tutor", compact('teacher'));
    }

}
