<?php

namespace ali\Media\Services;

use ali\Media\Contracts\FileServiceContract;
use ali\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class VideoFileService extends DefaultFileService implements FileServiceContract
{

    public static function upload(UploadedFile $file, string $fileName, string $dir ,bool $is_private): array
    {

        if ($is_private) {
            self::is_private_for_share_host();
        }

        $extension = $file->getClientOriginalExtension();


        Storage::putFileAs($dir, $file, $fileName . '.' . $extension);

        $path = $fileName . '.' . $extension;

        return ["video" => $path];
    }


    public static function thumb(Media $media)
    {
        return url('/img/vide-thumb.png');
    }


    public static function getFileName()
    {
        if (static::$media->is_private) {
            self::is_private_for_share_host();
        }

        return (static::$media->is_private ? 'private/' : 'public/') . static::$media->files['video'];
    }

    public static function stream(Media $media)
    {

        static::$media = $media;


        $fileName = static::getFileName();
        $length = Storage::size($fileName);


        $file = Storage::get($fileName);

        $response = Response::make($file, 200);
        $response->header('Content-Type', Storage::mimeType(static::getFileName()));
        $response->header('Content-Disposition', "attachment; filename='" . static::$media->filename . "'");
        $response->header('Accept-Ranges', 'bytes');
        $response->header('Content-Length', $length);

        return $response;
    }



}
