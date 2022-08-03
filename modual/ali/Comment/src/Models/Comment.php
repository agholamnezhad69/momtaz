<?php

namespace ali\Comment\Models;

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


}
