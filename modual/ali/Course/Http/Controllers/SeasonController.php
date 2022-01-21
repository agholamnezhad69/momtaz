<?php

namespace ali\Course\Http\Controllers;

use ali\Common\Responses\AjaxResponses;
use ali\Course\Http\Requests\SeasonRequest;
use ali\Course\Models\Season;
use ali\Course\Repositories\CourseRepo;
use ali\Course\Repositories\SeasonRepo;
use App\Http\Controllers\Controller;


class SeasonController extends Controller
{

    private $seasonRepo;

    public function __construct(SeasonRepo $seasonRepo)
    {
        $this->seasonRepo = $seasonRepo;
    }

    public function store($courseId, SeasonRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($courseId);
        $this->authorize('createSeason', $course);
        $this->seasonRepo->store($courseId, $request);
        newFeedbacks();
        return back();


    }

    public function edit($seasonId)
    {
        $season = $this->seasonRepo->findById($seasonId);
        $this->authorize('edit', $season);
        $season = $this->seasonRepo->findById($seasonId);
        return view("Courses::season.edit", compact('season'));


    }

    public function update($seasonId, SeasonRequest $request)
    {

        $season = $this->seasonRepo->findById($seasonId);
        $this->authorize('edit', $season);
        $this->seasonRepo->update($seasonId, $request);
        newFeedbacks();
        return back();


    }

    public function destroy($seasonId)
    {
        $season = $this->seasonRepo->findById($seasonId);

        $this->authorize('delete', $season);
        $season = $this->seasonRepo->findById($seasonId);
        $season->delete();
        return AjaxResponses::successResponse();

    }

    public function accept($id)
    {
        $this->authorize('change_confirmation_status', Season::class);
        if ($this->seasonRepo->updateConfirmationStatus($id, Season::CONFIRMATION_STATUS_ACCEPTED)) {

            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }

    public function reject($id)
    {
        $this->authorize('change_confirmation_status', Season::class);

        if ($this->seasonRepo->updateConfirmationStatus($id, Season::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }

    public function lock($id)
    {

        $this->authorize('change_confirmation_status', Season::class);

        if ($this->seasonRepo->updateStatus($id, Season::STATUS_LOCKED)) {

            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }

    public function unLock($id)
    {
        $this->authorize('change_confirmation_status', Season::class);

        if ($this->seasonRepo->updateStatus($id, Season::STATUS_OPENED)) {
            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }


}
