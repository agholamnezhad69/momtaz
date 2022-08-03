<?php

namespace ali\Media\Services;

use ali\Media\Contracts\FileServiceContract;
use ali\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ZipFileService extends DefaultFileService implements FileServiceContract
{


    public static function upload(UploadedFile $file, string $fileName, string $dir ,bool $is_private): array
    {
        if ($is_private) {
            self::is_private_for_share_host();
        }

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
        if (static::$media->is_private) {
            self::is_private_for_share_host();
        }

        return (static::$media->is_private ? 'private/' : 'public/') . static::$media->files['zip'];
    }

    public static function stream(Media $media)
    {

        static::$media = $media;

        $file = Storage::path(static::getFileName());

        return Response::download($file);


    }


}
