<?php

namespace ali\Media\Repositories;

use ali\Media\Contracts\FileServiceContract;
use ali\Media\Models\Media;
use Morilog\Jalali\Jalalian;


class MediaRepo
{

    private $file;
    private $is_private;

    public function privateUpload($fileName)
    {

        $this->file = $fileName;
        $this->is_private = true;
        return $this->upload();
    }

    public function publicUpload($fileName)
    {

        $this->file = $fileName;
        $this->is_private = false;
        return $this->upload();
    }

    private function normalizeExtension(): string
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }

    private function upload()
    {

        $extension = self::normalizeExtension();

        foreach (config('mediaFile.mediaTypeServices') as $type => $service) {

            if (in_array($extension, $service['extensions'])) {

                return $this->store($type);

            }
        }


    }

    private function store($type): Media
    {


        $media = new Media();
        $media->files = [$type => $this->file];
        $media->type = $type;
        $media->user_id = auth()->id();
        $media->filename = $this->file;
        $media->is_private = $this->is_private;
        $media->is_media_address = true;
        $media->save();
        return $media;
    }


}
