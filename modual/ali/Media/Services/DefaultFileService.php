<?php

namespace ali\Media\Services;

use ali\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

abstract class DefaultFileService
{
    public static $media;

    public static function delete($media)
    {
        foreach ($media->files as $file) {

            if ($media->is_private) {
                Storage::delete('private\\' . $file);
            } else {
                Storage::delete('public\\' . $file);
            }

        }
    }

     abstract public static function getFileName();


    public static function stream(Media $media)
    {

        static::$media = $media;

        $stream = Storage::readStream(static::getFileName());

        return response()->stream(function () use ($stream) {

            fpassthru($stream);
        },
        200,
            [
                'Content-Type'=> Storage::mimeType(static::getFileName()),
                'Content-Disposition' => "attachment; filename='" . static::$media->filename."'",
            ]
        );

    }

}
