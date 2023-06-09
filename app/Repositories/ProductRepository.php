<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductInterface;

class ProductRepository extends ModelRepository implements ProductInterface
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }

}
