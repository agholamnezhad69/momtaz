<?php

namespace ali\Media\Services;

use ali\Media\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
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


    public static function upload(UploadedFile $file, string $fileName, string $dir): array
    {
        $extension = $file->getClientOriginalExtension();
        $path = $dir . $fileName . '.' . $extension;
        Storage::putFileAs($dir, $file, $fileName . '.' . $extension);


        return self::resize($path, $fileName, $extension, $dir);
    }


}
