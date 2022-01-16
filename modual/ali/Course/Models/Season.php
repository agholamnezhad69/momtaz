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

    protected $guarded = [];

    public function course()
    {

        return $this->belongsTo(Course::class, 'course_id');

    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');

    }

}
