<?php

namespace ali\Course\Models;

use ali\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';

    public static $confirmation_statuses =
        [
            self::CONFIRMATION_STATUS_ACCEPTED,
            self::CONFIRMATION_STATUS_REJECTED,
            self::CONFIRMATION_STATUS_PENDING
        ];

    const STATUS_OPENED = 'opened';
    const STATUS_LOCKED = 'locked';

    public static $statuses = [
        self::STATUS_OPENED,
        self::STATUS_LOCKED
    ];


    protected $guarded = [];

    public function course()
    {

        return $this->belongsTo(Course::class, 'course_id');

    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'season_id');

    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');

    }

}
