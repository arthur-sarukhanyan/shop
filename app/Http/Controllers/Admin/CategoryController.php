<?php

namespace App\Http\Controllers\Admin;

use App\Facades\CategoryFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\ListCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\ListCategoryResource;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    /**
     * @param CreateCategoryRequest $request
     * @return ListCategoryResource
     */
    public function create(CreateCategoryRequest $request): ListCategoryResource
    {
        $data = $request->all();
        $created = CategoryFacade::create($data);
        return new ListCategoryResource($created);
    }

    /**
     * @param int $id
     * @param UpdateCategoryRequest $request
     * @return CategoryResource
     */
    public function update(UpdateCategoryRequest $request, int $id): CategoryResource
    {
        $data = $request->all();
        $updated = CategoryFacade::update($id, $data);
        return new CategoryResource($updated);
    }

    /**
     * @param ListCategoryRequest $request
     * @return View
     */
    public function viewList(ListCategoryRequest $request): View
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

    /**
     * @param int $id
     * @return View
     */
    public function viewUpdate(int $id): View
    {
        $list = CategoryFacade::list([]);
        $item = CategoryFacade::find($id);
        return view('admin.categories.update', ['list' => $list, 'item' => $item]);
    }
}
