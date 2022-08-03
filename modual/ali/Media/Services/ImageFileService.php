<?php

namespace ali\Media\Services;

use ali\Media\Contracts\FileServiceContract;
use ali\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ImageFileService extends DefaultFileService implements FileServiceContract
{
    protected static $sizes = ["300", "600"];

    private static function resize($path, $filename, $extension, $dir)
    {
        $img = Image::make(Storage::path($path));

        $imgs['original'] = $filename . '.' . $extension;

        foreach (self::$sizes as $size) {
            $imgs[$size] = $filename . '_' . $size . '.' . $extension;
            $img->resize($size, null, function ($aspect) {
                $aspect->aspectRatio();
            })
                ->save(Storage::path($dir) . $filename . '_' . $size . '.' . $extension);
        }

        return $imgs;

    }


    public static function upload(UploadedFile $file, string $fileName, string $dir,bool $is_private): array
    {

        if ($is_private) {
            self::is_private_for_share_host();
        }


        $extension = $file->getClientOriginalExtension();
        $path = $dir . $fileName . '.' . $extension;
        Storage::putFileAs($dir, $file, $fileName . '.' . $extension);


        return self::resize($path, $fileName, $extension, $dir);

    }


    public static function thumb(Media $media)
    {
        //for share host
//        return "/storage/public/" . $media->files['300'];

        return "/storage/" . $media->files['300'];
    }

    public static function getFileName()
    {
        if (static::$media->is_private) {
            self::is_private_for_share_host();
        }

        return (static::$media->is_private ? 'private/' : 'public/') . static::$media->files['original'];
    }

    public static function stream(Media $media)
    {


        static::$media = $media;

        $file = Storage::path(static::getFileName());

        return Response::download($file);


    }



}
