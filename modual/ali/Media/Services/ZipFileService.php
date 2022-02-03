<?php

namespace ali\Media\Services;

use ali\Media\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ZipFileService extends DefaultFileService implements FileServiceContract
{


    public static function upload(UploadedFile $file, string $fileName, string $dir): array
    {

        Storage::putFileAs($dir, $file, $fileName . '.' . $file->getClientOriginalExtension());

        $path =  $fileName . '.' . $file->getClientOriginalExtension();

        return ["zip" => $path];
    }


}
