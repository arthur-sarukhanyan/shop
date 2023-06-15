<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Repositories\Interfaces\ProductCategoryInterface;
class ProductCategoryRepository extends ModelRepository implements ProductCategoryInterface
{
    public function __construct()
    {
        parent::__construct(ProductCategory::class);
    }
}
