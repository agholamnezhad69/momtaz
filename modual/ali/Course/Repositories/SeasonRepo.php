<?php

namespace ali\Course\Repositories;

use ali\Course\Models\Course;
use ali\Course\Models\Season;
use Illuminate\Support\Str;

class SeasonRepo
{

    public function store($courseId, $values)
    {


        $courseRepo = new CourseRepo();

        if (is_null($values->number)) {

            $number = $courseRepo->findById($courseId)
                ->seasons()
                ->orderBy('number', 'desc')
                ->firstOrNew([])->number ? : 0;
            $number++;

        } else {
            $number = $values->number;
        }


        return Season::create([
            'title' => $values->title,
            'number' => $number,
            'course_id' => $courseId,
            'user_id' => auth()->user()->id,
            'confirmation_status' => Course::CONFIRMATION_STATUS_PENDING,
        ]);

    }


}
