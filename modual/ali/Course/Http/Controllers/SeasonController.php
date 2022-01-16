<?php

namespace ali\Course\Http\Controllers;

use ali\Course\Http\Requests\SeasonRequest;
use ali\Course\Repositories\SeasonRepo;
use App\Http\Controllers\Controller;


class SeasonController extends Controller
{


    public function store($id, SeasonRequest $request, SeasonRepo $seasonRepo)
    {

        $seasonRepo->store($id, $request);
        newFeedbacks();
        return back();


    }


}
