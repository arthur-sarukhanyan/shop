<?php

namespace App\Http\Controllers\Admin;

use App\Facades\FilterGroupFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterGroup\CreateFilterGroupRequest;
use App\Http\Requests\FilterGroup\ListFilterGroupRequest;
use App\Http\Requests\FilterGroup\UpdateFilterGroupRequest;
use App\Http\Resources\FilterGroup\FilterGroupResource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FilterGroupController extends Controller
{
    /**
     * @param CreateFilterGroupRequest $request
     * @return FilterGroupResource
     */
    public function create(CreateFilterGroupRequest $request):FilterGroupResource
    {
        $data = $request->all();
        $created = FilterGroupFacade::create($data);
        return new FilterGroupResource($created);
    }

    /**
     * @param int $id
     * @param UpdateFilterGroupRequest $request
     * @return FilterGroupResource
     */
    public function update(UpdateFilterGroupRequest $request, int $id): FilterGroupResource
    {
        $data = $request->all();
        $updated = FilterGroupFacade::update($id, $data);
        return new FilterGroupResource($updated);
    }

    /**
     * @param ListFilterGroupRequest $request
     * @return View
     */
    public function viewList(ListFilterGroupRequest $request): View
    {
        $params = $request->all();
        $list = FilterGroupFacade::listFiltered($params);
        return view('admin.filter-groups.main', ['list' => $list]);
    }

    /**
     * @return View
     */
    public function viewCreate(): View
    {
        $list = FilterGroupFacade::list([]);
        return view('admin.filter-groups.create', ['list' => $list]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewUpdate(int $id): View
    {
        $item = FilterGroupFacade::find($id);
        return view('admin.filter-groups.update', ['item' => $item]);
    }
}
