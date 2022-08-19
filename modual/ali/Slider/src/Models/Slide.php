<?php
namespace ali\Slider\Models;

use ali\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    const STATUS_DISABLE = "disable";
    const STATUS_ENABLE = "enable";

    const STATUSES = [
        self::STATUS_DISABLE,
        self::STATUS_ENABLE
    ];


    protected $guarded = [];
    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
