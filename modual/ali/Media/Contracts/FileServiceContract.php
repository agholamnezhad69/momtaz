<?php

namespace ali\Media\Contracts;

use ali\Media\Models\Media;
use Illuminate\Http\UploadedFile;

interface FileServiceContract
{
    public static function upload(UploadedFile $uploadedFile, string $fileName, string $dir): array;

    public static function delete(Media $media);

}
