<?php

namespace ali\Media\Services;

use ali\Media\Contracts\FileServiceContract;
use ali\Media\Models\Media;

class MediaFileService
{

    private static $dir;
    private static $file;
    private static $is_private;


    public static function publicUpload($file)
    {
        self::$dir = "public/";
        self::$file = $file;
        self::$is_private = false;
        return self::upload();
    }

    public static function privateUpload($file)
    {
        self::$dir = "private/";
        self::$file = $file;
        self::$is_private = true;
        return self::upload();
    }

    private static function upload()
    {

        $extension = self::normalizeExtension();

        foreach (config('mediaFile.mediaTypeServices') as $key => $service) {

            if (in_array($extension, $service['extensions'])) {

                return self::uploadByHandler(new $service['handler'], $key);

            }
        }


    }

    public static function delete($media)
    {

        switch ($media->type) {

            case 'image':
                ImageFileService::delete($media);
        }


    }


    private static function normalizeExtension(): string
    {
        return strtolower(self::$file->getClientOriginalExtension());
    }


    private static function fileNameGenerator(): string
    {
        return uniqid();
    }


    private static function uploadByHandler(FileServiceContract $handler, $key): Media
    {
        $fileName = self::fileNameGenerator();

        $media = new Media();
        $media->files = $handler::upload(self::$file, $fileName, self::$dir);
        $media->type = $key;
        $media->user_id = auth()->id();
        $media->filename = self::$file->getClientOriginalExtension();
        $media->is_private = self::$is_private;
        $media->save();
        return $media;
    }

}
