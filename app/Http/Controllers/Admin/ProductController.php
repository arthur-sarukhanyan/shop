<?php

namespace App\Http\Controllers\Admin;

use App\Facades\ProductFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\ListProductRequest;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    /**
     * @param CreateProductRequest $request
     * @return ProductResource
     */
    public function create(CreateProductRequest $request):ProductResource
    {
        $data = $request->all();
        $created = ProductFacade::create($data);
        return new ProductResource($created);
    }

    /**
     * @param ListProductRequest $request
     * @return View
     */
    public function list(ListProductRequest $request): View
    {
        $params = $request->all();
        $list = ProductFacade::list($params);
        return view('admin.products.main', ['list' => $list]);
    }

    /**
     * @return View
     */
    public function viewCreate(): View
    {
        return view('admin.products.create');
    }
}
