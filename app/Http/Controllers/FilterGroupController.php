<?php

namespace App\Http\Controllers;

use App\Facades\FilterGroupFacade;
use App\Http\Resources\FilterGroup\ListFilterGroupResource;

class FilterGroupController extends Controller
{
    /**
     * @return ListFilterGroupResource
     */
    public function list(): ListFilterGroupResource
    {
        $list = FilterGroupFacade::list(['filters']);
        return new ListFilterGroupResource($list);
    }
}
