<?php

namespace ali\Media\Services;

use ali\Media\Models\Media;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

abstract class DefaultFileService
{
    public static $media;

    public static function delete($media)
    {

        foreach ($media->files as $file) {

            if (($media->is_private) && (!$media->is_media_address)) {
                self::is_private_for_share_host();
                Storage::delete('private\\' . $file);
            } else if ((!$media->is_private) && (!$media->is_media_address)) {

                Storage::delete('public\\' . $file);
            }

        }
    }

    abstract public static function getFileName();


    public static function stream(Media $media)
    {

        static::$media = $media;

        /*************************************stream video*****************************************************/
//        $stream = Storage::readStream(static::getFileName());
//
//
//        return response()->stream(function () use ($stream) {
//            while (ob_get_level() > 0) ob_get_flush();
//            fpassthru($stream);
//        },
//            200,
//            [
//                'Content-Type' => Storage::mimeType(static::getFileName()),
//                'Content-Disposition' => "attachment; filename='" . static::$media->filename . "'",
//                'Accept-Ranges' => 'bytes',
//                'Content-Length' =>   $length,
//
//            ]
//        );
        /*****************************************without stream *****************************************************/


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

    public static function is_private_for_share_host()
    {


        resolve('filesystem')->forgetDisk('storage_root_address');
        app()['config']->set('filesystems.disks.storage_root_address.root', storage_path("app"));


    }


}
