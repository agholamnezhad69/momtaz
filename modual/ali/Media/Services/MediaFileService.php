<?php

namespace ali\Media\Services;

use ali\Media\Models\Media;

class MediaFileService
{

    public static function upload($file)
    {

        $extension = strtolower($file->getClientOriginalExtension());



        foreach (config('mediaFile.mediaTypeServices') as $key => $service) {

            if (in_array($extension, $service['extensions'])) {
                $media = new Media();
                $media->files = $service['handler']::upload($file);
                $media->type = $key;
                $media->user_id = auth()->id();
                $media->filename = $file->getClientOriginalExtension();
                $media->save();
                return $media;
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

}
