<?php

namespace ali\Course\Http\Controllers;


use ali\Common\Responses\AjaxResponses;
use ali\Course\Http\Requests\LessonRequest;
use ali\Course\Models\Course;
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

        $course = $courseRepo->findById($courseId);
        $this->authorize('creatLesson', $course);
        $seasons = $seasonRepo->getCourseSeasons($courseId);

        return view('Courses::lesson.create', compact('seasons', 'course'));

    }

    public function store($courseId, CourseRepo $courseRepo, LessonRequest $request)
    {
        $course = $courseRepo->findById($courseId);
        $this->authorize('creatLesson', $course);

        $request->request->add(["media_id" => MediaFileService::privateUpload($request->file('lesson_file'))->id]);
        $this->lessonRepo->store($courseId, $request);
        newFeedbacks();
        return redirect(route('courses.details', $courseId));


    }

    public function edit($courseId, $lessonId, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        $this->authorize('edit', $lesson);

        $course = $courseRepo->findById($courseId);
        $seasons = $seasonRepo->getCourseSeasons($courseId);
        $lesson = $this->lessonRepo->findById($lessonId);


        return view("Courses::lesson.edit", compact('course', 'seasons', 'lesson'));
    }

    public function update($courseId, $lessonId, LessonRequest $request)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        $this->authorize('edit', $lesson);


        if ($request->hasFile('lesson_file')) {

            $request->request->add(['media_id' => MediaFileService::privateUpload($request->file('lesson_file'))->id]);
            if ($lesson->media) {

                $lesson->media->delete();
            }
        } else {
            $request->request->add(['media_id' => $lesson->media_id]);
        }
        $this->lessonRepo->update($lessonId, $courseId, $request);

        newFeedbacks();
        return redirect(route('courses.details', $courseId));
    }

    public function destroy($courseId, $lessonId)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        $this->authorize("delete", $lesson);

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
            $this->authorize("delete", $lesson);
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

        $this->authorize("manage", Course::class);

        $this->lessonRepo->updateConfirmationStatus($lessonId, Lesson::CONFIRMATION_STATUS_ACCEPTED);
        AjaxResponses::successResponse();


    }

    public function acceptAll($courseId)
    {
        $this->authorize("manage", Course::class);
        $this->lessonRepo->acceptAll($courseId);
        newFeedbacks();
        return back();


    }

    public function acceptMultiple($courseId, Request $request)
    {
        $this->authorize("manage", Course::class);
        $lessonIds = explode(',', $request->ids);
        $this->lessonRepo->updateConfirmationStatus($lessonIds, Lesson::CONFIRMATION_STATUS_ACCEPTED);
        newFeedbacks();
        return back();


    }

    public function rejectMultiple($courseId, Request $request)
    {
        $this->authorize("manage", Course::class);
        $lessonIds = explode(',', $request->ids);
        $this->lessonRepo->updateConfirmationStatus($lessonIds, Lesson::CONFIRMATION_STATUS_REJECTED);
        newFeedbacks();
        return back();


    }

    public function reject($lessonId)
    {
        $this->authorize("manage", Course::class);
        $this->lessonRepo->updateConfirmationStatus($lessonId, Lesson::CONFIRMATION_STATUS_REJECTED);
        AjaxResponses::successResponse();


    }

    public function lock($lessonId)
    {
        $this->authorize("manage", Course::class);
        if ($this->lessonRepo->updateStatus($lessonId, Lesson::STATUS_LOCKED)) {

            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }

    public function unLock($lessonId)
    {

        $this->authorize("manage", Course::class);
        if ($this->lessonRepo->updateStatus($lessonId, Lesson::STATUS_OPENED)) {
            return AjaxResponses::successResponse();
        }
        return AjaxResponses::failResponse();
    }


}
