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

        foreach (config('mediaFile.mediaTypeServices') as $type => $service) {

            if (in_array($extension, $service['extensions'])) {

                return self::uploadByHandler(new $service['handler'], $type);

            }
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


    private static function uploadByHandler(FileServiceContract $handler, $type): Media
    {
        $fileName = self::fileNameGenerator();

        $media = new Media();
        $media->files = $handler::upload(self::$file, $fileName, self::$dir,self::$is_private);
        $media->type = $type;
        $media->user_id = auth()->id();
        $media->filename = self::$file->getClientOriginalName();
        $media->is_private = self::$is_private;
        $media->save();
        return $media;
    }


    public static function delete(Media $media)
    {
        foreach (config('mediaFile.mediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                $service['handler']::delete($media);
            }
        }

    }


    public static function thumb(Media $media)
    {


        foreach (config('mediaFile.mediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service["handler"]::thumb($media);
            }
        }
    }

    public static function getExtensions()
    {
        $extensions = [];
        foreach (config('mediaFile.mediaTypeServices') as $service) {

            foreach ($service['extensions'] as $extension) {
                $extensions[] = $extension;
            }
        }

        return implode(',', $extensions);
    }

    public static function stream(Media $media)
    {

        foreach (config('mediaFile.mediaTypeServices') as $type => $service) {
            if ($media->type == $type) {

                return $service["handler"]::stream($media);
            }
        }

    }
}
