<?php

namespace ali\Media\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Self_;
use phpDocumentor\Reflection\Types\This;

class ImageFileService
{
    protected static $sizes = ["300", "600"];

    public static function upload($file)
    {
        /*$dir = 'app\public\\';*/
        $dir = 'public\\';
        $fileName = uniqid();
        $extension = $file->getClientOriginalExtension();


        /*  $file->move(storage_path($dir), $fileName . '.' . $extension);*/
        Storage::putFileAs($dir, $file, $fileName . '.' . $extension);


        /* $path = $dir . '\\' . $fileName . '.' . $extension;*/
        $path = $dir . $fileName . '.' . $extension;

        return self::resize($path, $dir, $fileName, $extension);

    }

    public static function resize($path, $dir, $filename, $extension)
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

    public static function delete($media)
    {

        foreach ($media->files as $file) {

            Storage::delete('public\\' . $file);
        }

    }

}
