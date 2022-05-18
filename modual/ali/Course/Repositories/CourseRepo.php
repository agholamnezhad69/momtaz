<?php

namespace ali\Course\Repositories;

use ali\Course\Models\Course;
use ali\Course\Models\Lesson;
use ali\Course\Models\Season;
use Illuminate\Support\Str;

class CourseRepo
{

    public function store($values)
    {

        return Course::create([

            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => Str::slug($values->slug),
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'statues' => $values->status,
            'body' => $values->body,
            'confirmation_status' => Course::CONFIRMATION_STATUS_PENDING,


        ]);

    }

    public function paginate()
    {

        return Course::paginate();

    }

    public function findById($id)
    {

        return Course::query()->findOrFail($id);
    }

    public function update($id, $values)
    {
        Course::query()->where('id', $id)->update([
            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => $values->slug,
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'statues' => $values->status . "",
            'body' => $values->body,
        ]);
    }

    public function updateConfirmationStatus($id, string $status)
    {

        return Course::query()
            ->where('id', $id)
            ->update(["confirmation_status" => $status]);


    }

    public function updateStatus($id, string $status)
    {
        return Course::query()
            ->where('id', $id)
            ->update(["statues" => $status]);

    }

    public function getCourseByTeacherId()
    {

        return Course::query()->where('teacher_id', auth()->id())->get();


    }


    public function latestCourses()
    {

        return Course::query()
            ->where('confirmation_status', Course::CONFIRMATION_STATUS_ACCEPTED)
            ->latest()
            ->take(8)
            ->get();
    }

    public function getDuration($CourseId)
    {
        return $this->getLessonQuery($CourseId)
            ->sum('time');


    }

    public function getLessonsCount($courseId)
    {
        return $this->getLessonQuery($courseId)
            ->count();
    }

    public function getCourseLessons($courseId)
    {
        return $this->getLessonQuery($courseId)
            ->get();

    }

    private function getLessonQuery($CourseId): \Illuminate\Database\Eloquent\Builder
    {
        return Lesson::query()
            ->where('course_id', $CourseId)
            ->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED);
    }

    public function addStudentToCourse(Course $course, $studentId)
    {
        if (!$this->getCourseStudentById($course, $studentId)) {
            $course->students()->attach($studentId);
        }
    }

    public function getCourseStudentById(Course $course, $studentId)
    {
        return $course->students()->where("id", $studentId)->first();
    }

    public function haseStudent(Course $course, $user_id)
    {
        return $course->students->contains($user_id);
    }

    public function getAll($confirmation_status = null)
    {
        $query = Course::query();

        if ($confirmation_status) $query->where('confirmation_status', $confirmation_status);

        return $query->latest()->get();

    }


}
