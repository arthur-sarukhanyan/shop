<?php

namespace App\Repositories;

use App\Models\FilterGroup;
use App\Repositories\Interfaces\FilterGroupInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FilterGroupRepository extends ModelRepository implements FilterGroupInterface
{
    public function __construct()
    {
        parent::__construct(FilterGroup::class);
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params): Collection
    {
        $list = parent::all($params);

        return Cache::rememberForever('filter-groups-list', function () use ($list) {
            return $list;
        });
    }
}
