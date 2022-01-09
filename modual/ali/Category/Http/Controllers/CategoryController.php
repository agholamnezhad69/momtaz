<?php

namespace ali\Category\Http\Controllers;


use ali\Category\Models\Category;
use ali\Category\Repositories\CategoryRepo;
use ali\Category\Requests\CategoryRequest;
use ali\Common\Responses\AjaxResponses;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{

    private $repo;

    public function __construct(CategoryRepo $categoryRepo)
    {

        $this->repo = $categoryRepo;

    }

    public function index()
    {

        $this->authorize('manage', Category::class);

        $categories = $this->repo->all();

        return view("Categories::index", compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $this->authorize('manage', Category::class);
        $this->repo->store($request);

        return back();

    }

    public function edit($id)
    {
        $this->authorize('manage', Category::class);
        $category = $this->repo->finById($id);
        $categories = $this->repo->allExceptById($id);
        return view("Categories::edit", compact('category', "categories"));

    }

    public function update($id, CategoryRequest $request)
    {
        $this->authorize('manage', Category::class);
        $this->repo->update($id, $request);
        return back();
    }

    public function destroy($id)
    {
        $this->authorize('manage', Category::class);

        $this->repo->delete($id);

        return AjaxResponses::successResponse();


    }


}
