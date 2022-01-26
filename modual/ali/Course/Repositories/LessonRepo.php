<?php

namespace ali\Course\Repositories;

use ali\Course\Models\Course;
use ali\Course\Models\Lesson;
use ali\Course\Models\Season;


class LessonRepo
{

    public function store($courseId, $request)
    {

        return Lesson::query()
            ->create([
                "title" => $request->title,
                "slug" => $request->slug,//todo generate auto slug
                "course_id" => $courseId,
                "season_id" => $request->season_id,
                "user_id" => auth()->user()->id,
                "media_id" => $request->media_id,
                "time" => $request->time,
                "number" => $request->number,//toDo generate automatic number
                "free" => $request->free,
                "body" => $request->body,
            ]);


    }


}
