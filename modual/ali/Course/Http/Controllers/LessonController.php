<?php

namespace ali\Course\Http\Controllers;


use ali\Course\Repositories\CourseRepo;
use ali\Course\Repositories\SeasonRepo;
use App\Http\Controllers\Controller;


class LessonController extends Controller
{

    public function create($courseId, SeasonRepo $seasonRepo)
    {
        $seasons = $seasonRepo->getCourseSeasons($courseId);
        return view('Courses::lesson.create', compact('seasons'));

    }


}
