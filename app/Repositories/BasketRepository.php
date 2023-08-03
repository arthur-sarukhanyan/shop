<?php

namespace App\Repositories;

use App\Models\Basket;
use App\Repositories\Interfaces\BasketInterface;
class BasketRepository extends ModelRepository implements BasketInterface
{
    public function __construct()
    {
        parent::__construct(Basket::class);
    }
}
