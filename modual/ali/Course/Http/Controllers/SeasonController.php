<?php

namespace ali\Course\Http\Controllers;

use ali\Course\Http\Requests\SeasonRequest;
use ali\Course\Repositories\SeasonRepo;
use App\Http\Controllers\Controller;


class SeasonController extends Controller
{

    private $seasonRepo;

    public function __construct(SeasonRepo $seasonRepo)
    {
        $this->seasonRepo = $seasonRepo;
    }

    public function store($id, SeasonRequest $request)
    {

        $this->seasonRepo->store($id, $request);
        newFeedbacks();
        return back();


    }

    public function edit($seasonId)
    {

        $season = $this->seasonRepo->findById($seasonId);
        return view("Courses::season.edit", compact('season'));


    }

    public function update($seasonId, SeasonRequest $request)
    {

        $this->seasonRepo->update($seasonId, $request);
        newFeedbacks();
        return back();


    }


}
