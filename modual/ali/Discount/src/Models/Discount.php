<?php

namespace ali\Discount\Models;


use ali\Course\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

    protected $guarded = [];
    protected $casts = [
        "expire_at" => "datetime"
    ];

    public function courses()
    {

        return $this->morphedByMany(Course::class, 'discountable');

    }

}
