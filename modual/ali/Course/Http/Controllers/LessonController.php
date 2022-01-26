<?php

namespace ali\Course\Http\Controllers;


use ali\Course\Http\Requests\LessonRequest;
use ali\Course\Repositories\CourseRepo;
use ali\Course\Repositories\LessonRepo;
use ali\Course\Repositories\SeasonRepo;
use App\Http\Controllers\Controller;


class LessonController extends Controller
{
    private $lessonRepo;

    public function __construct(LessonRepo $lessonRepo)
    {

        $this->lessonRepo = $lessonRepo;

    }

    public function create($courseId, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {

        $seasons = $seasonRepo->getCourseSeasons($courseId);
        $course = $courseRepo->findById($courseId);
        return view('Courses::lesson.create', compact('seasons', 'course'));

    }

    public function store($courseId, LessonRequest $request)
    {

        $request->request->add(["media_id" => 51]);
        $this->lessonRepo->store($courseId, $request);
        newFeedbacks();
        return redirect(route('courses.details', $courseId));


    }


}
