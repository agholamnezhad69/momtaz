<?php

namespace ali\Media\Services;

use ali\Media\Models\Media;
use Illuminate\Support\Facades\Storage;

class DefaultFileService
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

    public function getFileName()
    {
        return (self::$media->is_private ? 'private/' : 'public/') . self::$media->files['zip'];
    }

    public static function stream(Media $media)
    {

        self::$media = $media;

        $stream = Storage::readStream(self::getFileName());

        return response()->stream(function () use ($stream) {

            fpassthru($stream);

        });

    }

}
