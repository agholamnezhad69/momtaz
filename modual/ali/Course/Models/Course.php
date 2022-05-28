<?php

namespace ali\Course\Models;

use ali\Category\Models\Category;
use ali\Course\Repositories\CourseRepo;
use ali\Course\Repositories\LessonRepo;
use ali\Discount\Models\Discount;
use ali\Discount\Repositories\DiscountRepo;
use ali\Discount\Services\DiscountService;
use ali\Media\Models\Media;
use ali\Payment\Models\Payment;
use ali\Ticket\Models\Ticket;
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

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    public function payment()
    {

        return $this->payments()->first();

    }

    public function tickets()
    {
        return $this->morphMany(Ticket::class, "ticketable");
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

    public function getDiscount()
    {
        $discountRepo = new DiscountRepo();
        $discount = $discountRepo->getCourseBiggerDiscount($this->id);
        $globalDiscount = $discountRepo->getGlobalBiggerDiscount();

        if ($discount == null && $globalDiscount == null) return null;
        if ($discount != null && $globalDiscount == null) return $discount;
        if ($discount == null && $globalDiscount != null) return $globalDiscount;

        if ($globalDiscount->percent > $discount->percent) return $globalDiscount;

        return $discount;

    }


    public function getDiscountPercent()
    {
        $discount = $this->getDiscount();
        if ($discount) {
            return $discount->percent;
        }
        return 0;
    }

    public function getDiscountAmount()
    {

        $percent = $this->getDiscountPercent();
        return DiscountService::calculateDiscountAmount($this->price, $percent);

    }

    public function getFinalPrice($code = null, $withDiscounts = false)
    {

        $discounts = [];

        $amount = $this->price;
        $discount = $this->getDiscount();

        if ($discount) {
            $discounts[] = $discount;
            $amount = $this->price - $this->getDiscountAmount();
        }


        if ($code) {
            $discountRepo = new DiscountRepo();
            $discountFromCode = $discountRepo->getValidDiscountByCode($code, $this->id);
            if ($discountFromCode) {
                $discounts[] = $discountFromCode;
                $amount = $amount - DiscountService::calculateDiscountAmount($amount, $discountFromCode->percent);
            }

        }

        if ($withDiscounts) return [$amount, $discounts];

        return $amount;

    }

    public function getFormattedFinalPrice()
    {

        return number_format($this->getFinalPrice());

    }

    public function getFormattedPrice()
    {

        return number_format($this->price);

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

    public function hasStudent($student_id)
    {
        return resolve(CourseRepo::class)->haseStudent($this, $student_id);
    }

    public function downloadLinks(): array
    {

        $links = [];
        foreach (resolve(CourseRepo::class)->getCourseLessons($this->id) as $lesson) {

            $links[] = $lesson->downloadLink();
        }

        return $links;


    }


    public function discounts()
    {

        return $this->morphToMany(Discount::class, 'discountable');

    }


}
