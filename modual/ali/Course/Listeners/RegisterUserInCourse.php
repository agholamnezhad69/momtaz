<?php

namespace ali\Course\Listeners;


use ali\Course\Models\Course;
use ali\Course\Repositories\CourseRepo;

class RegisterUserInCourse
{

    public function __construct()
    {

    }

    public function handle($event)
    {


        if ($event->payment->paymentable_type == Course::class) {

            resolve(CourseRepo::class)->addStudentToCourse($event->payment->paymentable, $event->payment->buyer_id);

        }

    }
}
