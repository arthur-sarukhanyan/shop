<?php

namespace App\Http\Controllers;

use App\Facades\ProductFacade;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\ListProductRequest;
use App\Http\Resources\Product\ListProductResource;
use App\Http\Resources\Product\ProductResource;

class ProductController extends Controller
{
    /**
     * @param CreateProductRequest $request
     * @return ProductResource
     */
    public function create(CreateProductRequest $request): ProductResource
    {
        $data = $request->all();
        $created = ProductFacade::create($data);
        return new ProductResource($created);
    }

    /**
     * @param ListProductRequest $request
     * @return ListProductResource
     */
    public function list(ListProductRequest $request): ListProductResource
    {
        $params = $request->all();
        $list = ProductFacade::list($params);
        return new ListProductResource($list);
    }

    /**
     * @param int $id
     * @return ProductResource
     */
    public function one(int $id): ProductResource
    {
        $item = ProductFacade::find($id);
        return new ProductResource($item);
    }
}
