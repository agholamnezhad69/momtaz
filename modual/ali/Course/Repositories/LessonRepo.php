<?php

namespace ali\Course\Repositories;

use ali\Course\Models\Course;
use ali\Course\Models\Lesson;
use ali\Course\Models\Season;
use Illuminate\Support\Str;


class LessonRepo
{

    public function findById($lessonId)
    {
        return Lesson::query()->findOrFail($lessonId);
    }

    public function store($courseId, $request)
    {

        $number = $this->generateNumber($request->number, $courseId);
        return Lesson::query()
            ->create([
                "title" => $request->title,
                "slug" => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
                "course_id" => $courseId,
                "season_id" => $request->season_id,
                "user_id" => auth()->user()->id,
                "media_id" => $request->media_id,
                "time" => $request->time,
                "number" => $number,
                "free" => $request->free,
                "body" => $request->body,
            ]);


    }

    public function generateNumber($number, $courseId)
    {
        $courseRepo = new CourseRepo();

        if (is_null($number)) {

            $number = $courseRepo->findById($courseId)
                ->lessons()
                ->orderBy('number', 'desc')
                ->firstOrNew([])->number ?: 0;


            $number++;
        }
        return $number;
    }

    public function paginate($course_id)
    {

        return Lesson::query()->where('course_id', $course_id)->orderBy('number')->paginate();

    }

    public function updateConfirmationStatus($id, string $status)
    {

        return Lesson::query()
            ->where('id', $id)
            ->update(["confirmation_status" => $status]);


    }


}
