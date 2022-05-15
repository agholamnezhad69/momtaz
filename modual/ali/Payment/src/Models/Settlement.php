<?php

namespace ali\Payment\Models;


use ali\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model


{
    protected $guarded = [];
    const STATUS_PENDING = "pending";
    const STATUS_SETTLED = "settled";
    const STATUS_REJECTED = "rejected";
    const STATUS_CANCELED = "canceled";

    public static $statues = [
        self::STATUS_PENDING,
        self::STATUS_SETTLED,
        self::STATUS_REJECTED,
        self::STATUS_CANCELED
    ];

    protected $casts = [
        "to" => "json",
        "from" => "json"
    ];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');

    }

    public function getStatusCssClass()
    {

        if ($this->status == Settlement::STATUS_SETTLED) return "text-success";

        if ($this->status == Settlement::STATUS_PENDING) return "text-warning";

        if ($this->status == Settlement::STATUS_REJECTED) return "text-error";


    }


}
