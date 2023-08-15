<?php

namespace App\Http\Controllers;

use App\Facades\CategoryFacade;
use App\Http\Resources\Category\ListCategoryResource;

class CategoryController extends Controller
{
    /**
     * @return ListCategoryResource
     */
    public function list(): ListCategoryResource
    {
        $list = CategoryFacade::list([]);
        return new ListCategoryResource($list);
    }
}
