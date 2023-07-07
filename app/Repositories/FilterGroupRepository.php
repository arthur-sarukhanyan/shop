<?php

namespace App\Repositories;

use App\Models\FilterGroup;
use App\Repositories\Interfaces\FilterGroupInterface;
class FilterGroupRepository extends ModelRepository implements FilterGroupInterface
{
    public function __construct()
    {
        parent::__construct(FilterGroup::class);
    }
}
