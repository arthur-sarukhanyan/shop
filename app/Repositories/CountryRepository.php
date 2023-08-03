<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Interfaces\CountryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CountryRepository extends ModelRepository implements CountryInterface
{
    public function __construct()
    {
        parent::__construct(Country::class);
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params): Collection
    {
        $list = parent::all($params);

        return Cache::rememberForever('countries-list', function () use ($list) {
            return $list;
        });
    }
}
