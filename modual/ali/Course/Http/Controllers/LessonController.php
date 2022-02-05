<?php

namespace ali\Course\Http\Controllers;


use ali\Common\Responses\AjaxResponses;
use ali\Course\Http\Requests\LessonRequest;
use ali\Course\Models\Lesson;
use ali\Course\Repositories\CourseRepo;
use ali\Course\Repositories\LessonRepo;
use ali\Course\Repositories\SeasonRepo;
use ali\Media\Services\MediaFileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LessonController extends Controller
{
    private $lessonRepo;

    public function __construct(LessonRepo $lessonRepo)
    {

        $this->lessonRepo = $lessonRepo;

    }

    public function create($courseId, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {

        $seasons = $seasonRepo->getCourseSeasons($courseId);
        $course = $courseRepo->findById($courseId);
        return view('Courses::lesson.create', compact('seasons', 'course'));

    }

    public function store($courseId, LessonRequest $request)
    {

        $request->request->add(["media_id" => MediaFileService::privateUpload($request->file('lesson_file'))->id]);
        $this->lessonRepo->store($courseId, $request);
        newFeedbacks();
        return redirect(route('courses.details', $courseId));


    }

    public function destroy($courseId, $lessonId)
    {
        $lesson = $this->lessonRepo->findById($lessonId);

        if ($lesson->media) {
            $lesson->media->delete();
        }
        $lesson->delete();
        AjaxResponses::successResponse();

    }

    public function destroyMultiple(Request $request)
    {

        $lessonIds = explode(',', $request->ids);

        foreach ($lessonIds as $id) {

            $lesson = $this->lessonRepo->findById($id);
            if ($lesson->media) {

                $lesson->media->delete();
            }
            $lesson->delete();
        }
        newFeedbacks();
        return back();


    }

    public function accept($lessonId)
    {

        $this->lessonRepo->updateConfirmationStatus($lessonId, Lesson::CONFIRMATION_STATUS_ACCEPTED);
        AjaxResponses::successResponse();


    }

    public function reject($lessonId)
    {

        $this->lessonRepo->updateConfirmationStatus($lessonId, Lesson::CONFIRMATION_STATUS_REJECTED);
        AjaxResponses::successResponse();


    }
    public function lock($lessonId)
    {

        if ($this->lessonRepo->updateStatus($lessonId, Lesson::STATUS_LOCKED)) {

            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }

    public function unLock($lessonId)
    {


        if ($this->lessonRepo->updateStatus($lessonId, Lesson::STATUS_OPENED)) {
            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }


}
