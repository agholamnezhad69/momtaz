<?php

namespace App;

use ali\Media\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ZipFileService implements FileServiceContract
{


    public static function upload(UploadedFile $file): array
    {
        $dir = 'private\\';
        $fileName = uniqid();
        $extension = $file->getClientOriginalExtension();

        Storage::putFileAs($dir, $file, $fileName . '.' . $extension);

        $path = $dir . $fileName . '.' . $extension;

        return ["zip" => $path];
    }

    public static function delete()
    {
        // TODO: Implement delete() method.
    }
}
