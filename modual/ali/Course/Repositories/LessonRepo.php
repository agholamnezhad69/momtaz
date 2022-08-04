<?php

namespace ali\Course\Repositories;

use ali\Course\Models\Lesson;
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
                "media_id" => $request->media_id,
                'user_id' => auth()->user()->id,
                "time" => $request->time,
                "number" => $number,
                "is_free" => $request->is_free,
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

    public function updateConfirmationStatus($lessonId, string $status)
    {
        if (is_array($lessonId)) {
            return Lesson::query()->wherein('id', $lessonId)->update([
                'confirmation_status' => $status
            ]);
        }
        return Lesson::query()
            ->where('id', $lessonId)
            ->update(["confirmation_status" => $status]);
    }

    public function updateStatus($id, string $status)
    {
        return Lesson::query()
            ->where('id', $id)
            ->update(["status" => $status]);

    }

    public function update($lessonId, $courseId, $request)
    {

        $number = $this->generateNumber($request->number, $courseId);

        Lesson::where('id', $lessonId)->update([
            "title" => $request->title,
            "slug" => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            "course_id" => $courseId,
            "season_id" => $request->season_id,
            "media_id" => $request->media_id,
            "time" => $request->time,
            "number" => $number,
            "is_free" => $request->is_free,
            "body" => $request->body,
        ]);

    }

    public function acceptAll($courseId)
    {

        Lesson::query()->where('course_id', $courseId)->update([
            'confirmation_status' => Lesson::CONFIRMATION_STATUS_ACCEPTED
        ]);
    }

    public function getAcceptedLessons(int $course_id)
    {

        return Lesson::query()
            ->where('course_id', $course_id)
            ->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED)
            ->get();

    }

    public function getFirstLesson(int $course_id)
    {
        return Lesson::query()
            ->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED)
            ->where('course_id', $course_id)
            ->orderBy('number', 'asc')
            ->first();

    }

    public function getLesson(int $lessonId, int $courseId)
    {
        return Lesson::query()
            ->where('id', $lessonId)
            ->where('course_id', $courseId)
            ->first();

    }


}
