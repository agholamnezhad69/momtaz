<?php

return [

    "mediaTypeServices" => [
        "image" => [
            "extensions" => [
                "png", "jpg", "jpeg"
            ],
            "handler" => \ali\Media\Services\ImageFileService::class
        ],
        "video" => [
            "extensions" => [
                "avi", "mp4", "mkv"
            ],
            "handler" => \ali\Media\Services\VideoFileService::class
        ],
        "zip" => [
            "extensions" => [
                "zip", "rar", "tar"
            ],
            "handler" => \ali\Media\Services\ZipFileService::class
        ]

    ]

];
