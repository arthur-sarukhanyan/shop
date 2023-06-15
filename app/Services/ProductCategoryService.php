<?php

namespace App\Services;

use App\Facades\CategoryFacade;
use App\Repositories\Interfaces\ProductCategoryInterface as RepositoryInterface;
use App\Services\Interfaces\ProductCategoryInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param int $modelId
     * @return void
     */
    public function setCategoryPath(int $modelId): void
    {
        $list = $this->modelRepository->findBy('product_id', $modelId);
        foreach ($list as $item) {
            $path = $this->generatePath($item);
            $data = ['path' => $path];
            $this->modelRepository->update($item->id, $data);
        }
    }

    public function generatePath(Model $item): string
    {
        $path = '|' . $item->category_id . '|';
        $category = CategoryFacade::find($item->category_id);

        while ($category->parent_id) {
            $path .= $category->parent_id . '|';
            $category = CategoryFacade::find($category->parent_id);
        }

        return $path;
    }
}
