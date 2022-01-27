<?php

namespace ali\Media\Services;

use Illuminate\Support\Facades\Storage;

class VideoFileService
{
    public static function upload($file)
    {

        $dir = 'private\\';
        $fileName = uniqid();
        $extension = $file->getClientOriginalExtension();


        Storage::putFileAs($dir, $file, $fileName . '.' . $extension);

        $path = $dir . $fileName . '.' . $extension;

        return ["video" => $path];

    }

}
