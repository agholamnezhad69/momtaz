<?php

namespace ali\Media\Services;

use ali\Media\Contracts\FileServiceContract;
use ali\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ZipFileService extends DefaultFileService implements FileServiceContract
{


    public static function upload(UploadedFile $file, string $fileName, string $dir): array
    {

        Storage::putFileAs($dir, $file, $fileName . '.' . $file->getClientOriginalExtension());

        $path = $fileName . '.' . $file->getClientOriginalExtension();

        return ["zip" => $path];
    }

    public static function thumb(Media $media)
    {
        return url('/img/zip-thumb.png');
    }

    public static function getFileName()
    {
        return (static::$media->is_private ? 'private/' : 'public/') . static::$media->files['zip'];
    }

}
