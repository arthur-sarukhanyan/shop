<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\ListProductRequest;
use App\Http\Resources\Product\ListProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\RepositoryInterface;

class ProductController extends Controller
{
    private RepositoryInterface $modelRepository;

    /**
     * @param ProductInterface $modelRepository
     */
    public function __construct(ProductInterface $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param CreateProductRequest $request
     * @return ProductResource
     */
    public function create(CreateProductRequest $request):ProductResource
    {
        $data = $request->all();
        $created = $this->modelRepository->create($data);
        return new ProductResource($created);
    }

    public function list(ListProductRequest $request):ListProductResource
    {
        $params = $request->all();
        $list = $this->modelRepository->all($params);
        return new ListProductResource($list);
    }
}
