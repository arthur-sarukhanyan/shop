<?php

namespace App\Repositories;

use App\Models\BasketItem;
use App\Repositories\Interfaces\BasketItemInterface;
class BasketItemRepository extends ModelRepository implements BasketItemInterface
{
    public function __construct()
    {
        parent::__construct(BasketItem::class);
    }
}
