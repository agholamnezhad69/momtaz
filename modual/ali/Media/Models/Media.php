<?php

namespace ali\Media\Models;

use ali\Media\Services\MediaFileService;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

 //   protected $guarded = [];

    protected $casts = [
        'files' => 'json'
    ];

    protected static function booted()
    {
        static::deleting(function ($media) {
            MediaFileService::delete($media);
        });
    }

    public function getThumbAttribute()
    {
        return MediaFileService::thumb($this);
    }

    public function getUrl($quality = "original"): string
    {
        return "/storage/" . $this->files[$quality];
    }


}
