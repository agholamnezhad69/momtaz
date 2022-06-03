<?php

namespace ali\Course\Repositories;

use ali\Course\Models\Course;
use ali\Course\Models\Lesson;
use ali\Course\Models\Season;
use Illuminate\Support\Str;

class CourseRepo
{
    private $query;

    public function __construct()
    {
        $this->query = Course::query();
    }

    public function joinTeacher()
    {
        $this->query
            ->join("users", "courses.teacher_id", "users.id")
            ->join("categories", "courses.category_id", "categories.id")
            ->select("courses.*", "users.id as userId", "users.name", "users.email");

        return $this;
    }

    public function searchCourseTitle($title)
    {
        if (!is_null($title))
            $this->query
                ->where('courses.title', "like", "%" . $title . "%");

        return $this;
    }

    public function searchCoursePriority($priority)
    {
        if (!is_null($priority))
            $this->query
                ->where('priority', "=", $priority);

        return $this;
    }

    public function searchCoursePrice($price)
    {
        if (!is_null($price))
            $this->query
                ->where('price', "=", $price);

        return $this;
    }

    public function searchCourseTeacher($teacherName)
    {
        if (!is_null($teacherName))
            $this->query
                ->where('name', "like", "%" . $teacherName . "%");

        return $this;

    }

    public function searchCategory($categoryId)
    {

        if (!is_null($categoryId))
            $this->query
                ->where("categories.id", "=", $categoryId);

        return $this;

    }
    public function searchStatus($status)
    {

        if (!is_null($status))
            $this->query
                ->where("confirmation_status", "=", $status);

        return $this;

    }

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

        return $this->query->latest()->paginate();

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

        return $this->query->where('teacher_id', auth()->id())->get();


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
