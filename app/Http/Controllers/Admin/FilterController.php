<?php

namespace App\Http\Controllers\Admin;

use App\Facades\FilterFacade;
use App\Facades\FilterGroupFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\CreateFilterRequest;
use App\Http\Requests\Filter\ListFilterRequest;
use App\Http\Requests\Filter\UpdateFilterRequest;
use App\Http\Resources\Filter\FilterResource;
use Illuminate\Contracts\View\View;

class FilterController extends Controller
{
    /**
     * @param CreateFilterRequest $request
     * @return FilterResource
     */
    public function create(CreateFilterRequest $request):FilterResource
    {
        $data = $request->all();
        $created = FilterFacade::create($data);
        return new FilterResource($created);
    }

    /**
     * @param int $id
     * @param UpdateFilterRequest $request
     * @return FilterResource
     */
    public function update(UpdateFilterRequest $request, int $id): FilterResource
    {
        $data = $request->all();
        $updated = FilterFacade::update($id, $data);
        return new FilterResource($updated);
    }

    /**
     * @param ListFilterRequest $request
     * @return View
     */
    public function viewList(ListFilterRequest $request): View
    {
        $params = $request->all();
        $list = FilterFacade::listFiltered($params);
        return view('admin.filters.main', ['list' => $list]);
    }

    /**
     * @return View
     */
    public function viewCreate(): View
    {
        $list = FilterGroupFacade::list([]);
        return view('admin.filters.create', ['list' => $list]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewUpdate(int $id): View
    {
        $list = FilterGroupFacade::list([]);
        $item = FilterFacade::find($id);
        return view('admin.filters.update', ['list' => $list, 'item' => $item]);
    }
}
