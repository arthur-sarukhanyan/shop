<?php

namespace App\Http\Controllers;

use App\Facades\FilterGroupFacade;
use App\Http\Resources\FilterGroup\ListFilterGroupResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FilterGroupController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function list(): AnonymousResourceCollection
    {
        $list = FilterGroupFacade::list(['filters']);
        return ListFilterGroupResource::collection($list);
    }
}
