<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryInterface;
class CategoryRepository extends ModelRepository implements CategoryInterface
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }
}
