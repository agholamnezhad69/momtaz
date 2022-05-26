<?php

namespace ali\Discount\Models;


use ali\Course\Models\Course;

use ali\Payment\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    const TYPE_ALL = "all";
    const TYPE_SPECIAL = "special";
    public static $types = [
        self::TYPE_ALL,
        self::TYPE_SPECIAL,
    ];
    protected $guarded = [];

    protected $casts = [
        "expire_at" => "datetime"
    ];

    public function payments()
    {
        return $this->belongsToMany(Payment::class,'discount_payment');
    }

    public function courses()
    {
        return $this->morphedByMany(Course::class, 'discountable');
    }

    protected static function booted()
    {
        static::deleting(function ($deletedDiscountModel) {
            $deletedDiscountModel->courses()->detach();
        });
    }

}
