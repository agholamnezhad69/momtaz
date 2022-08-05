<?php

namespace ali\Comment\Models;

use ali\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    const STATUS_NEW = "new";
    const STATUS_APPROVED = "approved";
    const STATUS_REJECT = "reject";

    public static $statues = [

        self::STATUS_NEW,
        self::STATUS_APPROVED,
        self::STATUS_REJECT,

    ];

    public function commentable()
    {

        return $this->morphTo();

    }


    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function comment()
    {

        return $this->belongsTo(Comment::class);
    }

    public function replies()
    {

        return $this->hasMany(Comment::class);

    }


    public function getStatusCssClass()
    {

        if ($this->status == Comment::STATUS_APPROVED) return "text-success";
        elseif ($this->status == Comment::STATUS_REJECT) return "text-error";

        return "text-warning";

    }

    public function notApprovedComments()
    {
        return $this->hasMany(Comment::class)->where("status", self::STATUS_NEW);

    }


}
