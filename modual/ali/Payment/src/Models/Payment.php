<?php

namespace ali\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model

{
    protected $guarded = [];
    const STATUS_PENDING = "pending";
    const STATUS_CANCELED = "canceled";
    const STATUS_SUCCESS = "success";
    const STATUS_ERROR = "error";

    public static $statuses =
        [
            self::STATUS_PENDING,
            self::STATUS_CANCELED,
            self::STATUS_SUCCESS,
            self::STATUS_ERROR
        ];


}
