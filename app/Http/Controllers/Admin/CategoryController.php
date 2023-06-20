<?php

namespace App\Http\Controllers\Admin;

use App\Facades\CategoryFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\ListCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    /**
     * @param CreateCategoryRequest $request
     * @return CategoryResource
     */
    public function create(CreateCategoryRequest $request):CategoryResource
    {
        $data = $request->all();
        $created = CategoryFacade::create($data);
        return new CategoryResource($created);
    }

    /**
     * @param ListCategoryRequest $request
     * @return View
     */
    public function list(ListCategoryRequest $request): View
    {
        $params = $request->all();
        $list = CategoryFacade::listFiltered($params);
        return view('admin.categories.main', ['list' => $list]);
    }

    /**
     * @return View
     */
    public function viewCreate(): View
    {
        $list = CategoryFacade::list([]);
        return view('admin.categories.create', ['list' => $list]);
    }
}
