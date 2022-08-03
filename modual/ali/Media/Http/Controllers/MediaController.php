<?php

namespace ali\Media\Http\Controllers;


use ali\Media\Models\Media;
use ali\Media\Services\MediaFileService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class MediaController extends Controller
{

    public function download(Media $media, Request $request)
    {

        if (!$request->hasValidSignature()) {
            abort(401);
        }

        return MediaFileService::stream($media);


    }


}
