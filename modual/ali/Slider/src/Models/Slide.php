<?php

namespace ali\Slider\Models;

use ali\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{


    protected $guarded = [];

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function getStatus()
    {

        if ($this->status)
            return "فعال";
        return "غیر فعال";

    }
}
