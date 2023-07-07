<?php

namespace App\Repositories;

use App\Models\Filter;
use App\Repositories\Interfaces\FilterInterface;
class FilterRepository extends ModelRepository implements FilterInterface
{
    public function __construct()
    {
        parent::__construct(Filter::class);
    }
}
