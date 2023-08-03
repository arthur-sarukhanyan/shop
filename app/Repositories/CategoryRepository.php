<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryRepository extends ModelRepository implements CategoryInterface
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params): Collection
    {
        $list = parent::all($params);

        return Cache::rememberForever('categories-list', function () use ($list) {
            return $list;
        });
    }
}
