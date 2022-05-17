<?php

namespace ali\Discount\Models;


use ali\Course\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{


    public function courses()
    {

        return $this->morphedByMany(Course::class, 'discountable');

    }

}
