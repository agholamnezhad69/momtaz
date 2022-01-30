<?php

namespace ali\Media\Contracts;

use Illuminate\Http\UploadedFile;

interface FileServiceContract
{
    public static function upload(UploadedFile $uploadedFile): array;

    public static function delete();

}
