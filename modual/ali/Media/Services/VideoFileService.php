<?php

namespace ali\Media\Services;

use ali\Media\Contracts\FileServiceContract;
use ali\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoFileService implements FileServiceContract
{

    public static function upload(UploadedFile $file, string $fileName, string $dir): array
    {

        $extension = $file->getClientOriginalExtension();


        Storage::putFileAs($dir, $file, $fileName . '.' . $extension);

        $path = $dir . $fileName . '.' . $extension;

        return ["video" => $path];
    }

    public static function delete(Media $media)
    {
        // TODO: Implement delete() method.
    }
}
