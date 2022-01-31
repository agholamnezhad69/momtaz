<?php

namespace App;

use ali\Media\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ZipFileService implements FileServiceContract
{


    public static function upload(UploadedFile $file, string $fileName, string $dir): array
    {

        Storage::putFileAs($dir, $file, $fileName . '.' . $file->getClientOriginalExtension());

        $path = $dir . $fileName . '.' . $file->getClientOriginalExtension();

        return ["zip" => $path];
    }

    public static function delete($media)
    {
        // TODO: Implement delete() method.
    }
}
