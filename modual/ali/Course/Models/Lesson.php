<?php

namespace ali\Course\Models;

use ali\Media\Models\Media;
use ali\Media\Services\MediaFileService;
use ali\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Lesson extends Model
{
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    public static $confirmation_statuses = [
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

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }

    public function downloadLink()
    {
        if ($this->media_id) {
            return URL::temporarySignedRoute('media.download',
                now()->addDay(),
                ['media' => $this->media_id]
            );
        }
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function media()
    {

        return $this->belongsTo(Media::class);

    }

    public function getConfirmationStatusCssClass()
    {
        if ($this->confirmation_status == self:: CONFIRMATION_STATUS_ACCEPTED) return "text-success";
        elseif ($this->confirmation_status == self::CONFIRMATION_STATUS_REJECTED) return "text-error";

    }

    public function getStatusCssClass()
    {
        if ($this->status == self:: STATUS_OPENED) return "text-success";
        elseif ($this->status == self::STATUS_LOCKED) return "text-error";

    }

    public function is_free()
    {

        return $this->is_free ? 'رایگان' : 'نقدی';

    }

    public function path()
    {
        return $this->course->path() . '?lesson=l-' . $this->id . '-' . $this->slug;

    }


}
