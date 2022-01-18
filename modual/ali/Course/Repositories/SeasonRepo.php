<?php

namespace ali\Course\Repositories;

use ali\Course\Models\Course;
use ali\Course\Models\Season;


class SeasonRepo
{

    public function store($courseId, $values)
    {


        $number = $this->generateNumber($values->number, $courseId);


        return Season::create([
            'title' => $values->title,
            'number' => $number,
            'course_id' => $courseId,
            'user_id' => auth()->user()->id,
            'confirmation_status' => Course::CONFIRMATION_STATUS_PENDING,
        ]);

    }

    public function findById($seasonId)
    {

        return Season::query()->findOrFail($seasonId);
    }

    public function update($seasonId, $values)
    {

        $season = $this->findById($seasonId);

        return Season::query()->where('id', $seasonId)->update([
            'title' => $values->title,
            'number' => $this->generateNumber($values->number, $season->course->id),

        ]);
    }

    public function generateNumber($number, $courseId)
    {
        $courseRepo = new CourseRepo();

        if (is_null($number)) {

            $number = $courseRepo->findById($courseId)
                ->seasons()
                ->orderBy('number', 'desc')
                ->firstOrNew([])->number ?: 0;


            $number++;
        }
        return $number;
    }
    public function updateConfirmationStatus($id, string $status)
    {

        return Season::query()
            ->where('id', $id)
            ->update(["confirmation_status" => $status]);


    }
    public function updateStatus($id, string $status)
    {
        return Season::query()
            ->where('id', $id)
            ->update(["status" => $status]);

    }


}
