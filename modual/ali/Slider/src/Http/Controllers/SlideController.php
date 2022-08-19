<?php

namespace ali\Slider\Http\Controllers;

use App\Http\Controllers\Controller;
use ali\Common\Responses\AjaxResponses;
use ali\Media\Services\MediaFileService;
use ali\Slider\Http\Requests\SlideRequest;
use ali\Slider\Models\Slide;
use ali\Slider\Repositories\SlideRepo;

class SlideController extends Controller
{
    public function index(SlideRepo $repo)
    {
        $this->authorize('manage', Slide::class);
        $slides = $repo->all();
        return view("Slider::index", compact("slides"));
    }

    public function store(SlideRequest $request, SlideRepo $repo)
    {
        $this->authorize('manage', Slide::class);
        $request->request->add(['media_id' => MediaFileService::publicUpload($request->file('image'))->id]);
        $repo->store($request);
        newFeedbacks();
        return redirect()->route('slides.index');
    }

    public function edit(Slide $slide)
    {
        $this->authorize('manage', Slide::class);
        $this->authorize('manage', Slide::class);
        return view("Slider::edit", compact("slide"));

    }

    public function update(Slide $slide, SlideRepo $repo, SlideRequest $request)
    {
        $this->authorize('manage', Slide::class);
        if ($request->hasFile('image')) {
            $request->request->add(['media_id' => MediaFileService::publicUpload($request->file('image'))->id]);
            if ($slide->media)
                $slide->media->delete();
        } else {
            $request->request->add(['media_id' => $slide->media_id]);
        }
        $repo->update($slide->id, $request);
        return redirect()->route('slides.index');
    }

    public function destroy(Slide $slide)
    {
        $this->authorize('manage', Slide::class);
        if ($slide->media) {
            $slide->media->delete();
        }
        $slide->delete();

        return AjaxResponses::SuccessResponse();
    }
}
