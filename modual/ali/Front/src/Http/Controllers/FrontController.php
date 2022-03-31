<?php

namespace ali\Front\Http\Controllers;

use Illuminate\Routing\Controller;


class FrontController extends Controller
{

    public function index()
    {
        return view('Front::index');
    }

}
