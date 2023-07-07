<?php

namespace App\Http\Controllers\Admin;

use App\Facades\CategoryFacade;
use App\Facades\ProductFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\ListProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\SuccessResource;
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
     * @param int $id
     * @param UpdateProductRequest $request
     * @return ProductResource
     */
    public function update(UpdateProductRequest $request, int $id): ProductResource
    {
        $data = $request->all();
        $updated = ProductFacade::update($id, $data);
        return new ProductResource($updated);
    }

    /**
     * @param int $id
     * @return SuccessResource
     */
    public function delete(int $id): SuccessResource
    {
        ProductFacade::delete($id);
        return new SuccessResource('Successfully deleted');
    }

    /**
     * @param ListProductRequest $request
     * @return View
     */
    public function viewList(ListProductRequest $request): View
    {
        $params = $request->all();
        $list = ProductFacade::list($params);
        $pagination = ProductFacade::pagination($params);

        return view('admin.products.main', ['list' => $list, 'pagination' => $pagination]);
    }

    /**
     * @return View
     */
    public function viewCreate(): View
    {
        $listCategories = CategoryFacade::list([]);
        return view('admin.products.create', ['listCategories' => $listCategories]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewUpdate(int $id): View
    {
        $listCategories = CategoryFacade::list([]);
        $item = ProductFacade::find($id, ['categories']);
        return view('admin.products.update', ['listCategories' => $listCategories, 'item' => $item]);
    }
}
