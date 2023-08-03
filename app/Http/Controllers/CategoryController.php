<?php

namespace App\Http\Controllers;

use App\Facades\CategoryFacade;
use App\Http\Resources\Category\ListCategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        $list = CategoryFacade::list([]);
        return ListCategoryResource::collection($list);
    }
}
