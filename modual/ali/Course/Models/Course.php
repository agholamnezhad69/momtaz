<?php

namespace ali\Course\Models;

use ali\Category\Models\Category;
use ali\Course\Repositories\CourseRepo;
use ali\Course\Repositories\LessonRepo;
use ali\Media\Models\Media;
use ali\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * @var mixed
     */

    protected $guarded = [];

    const TYPE_FREE = 'free';
    const TYPE_CASH = 'cash';
    public static $types = [self::TYPE_FREE, self::TYPE_CASH];


    const STATUS_COMPLETED = 'completed';
    const STATUS_NOT_COMPLETED = 'not-completed';
    const STATUS_LOCKED = 'locked';

    public static $statuses = [self::STATUS_COMPLETED, self::STATUS_NOT_COMPLETED, self::STATUS_LOCKED];


    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';

    public static $confirmation_statuses = [self::CONFIRMATION_STATUS_ACCEPTED, self::CONFIRMATION_STATUS_REJECTED, self::CONFIRMATION_STATUS_PENDING,];


    public function banner()
    {

        return $this->belongsTo(Media::class, 'banner_id');

    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');

    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');

    }

    public function seasons()
    {
        return $this->hasMany(Season::class);

    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);

    }

    public function getConfirmationStatusCssClass()
    {
        if ($this->confirmation_status == self:: CONFIRMATION_STATUS_ACCEPTED) return "text-success";
        elseif ($this->confirmation_status == self::CONFIRMATION_STATUS_REJECTED) return "text-error";

    }

    public function getDuration()
    {
        return (new CourseRepo())->getDuration($this->id);
    }

    public function formattedDuration()
    {


        $duration = $this->getDuration();

        $h = round($duration / 60) < 10 ? "0" . floor($duration / 60) : floor($duration / 60);
        $m = round($duration % 60) < 10 ? "0" . ($duration % 60) : ($duration % 60);

        return $h . ':' . $m . ':00';


    }

    public function getFormattedPrice()
    {

        return number_format($this->price);

    }

    public function getDiscountPercent()
    {
        //ToDo
        return 0;

    }

    public function getDiscountAmount()
    {
        //ToDo
        return 0;

    }

    public function getFinalPrice()
    {

        return $this->price - $this->getDiscountAmount();

    }

    public function getFormattedFinalPrice()
    {

        return number_format($this->getFinalPrice());

    }

    public function path()
    {

        return route('singleCourse', $this->id . '-' . $this->slug);

    }

    public function lessonsCount()
    {

        return (new CourseRepo())->getLessonsCount($this->id);

    }

    public function shortUrl()
    {

        return route('singleCourse', $this->id);

    }

    public function students()
    {

        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');

    }


}
