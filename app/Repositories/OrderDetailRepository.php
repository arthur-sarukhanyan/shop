<?php

namespace App\Repositories;

use App\Models\OrderDetail;
use App\Repositories\Interfaces\OrderDetailInterface;
class OrderDetailRepository extends ModelRepository implements OrderDetailInterface
{
    public function __construct()
    {
        parent::__construct(OrderDetail::class);
    }
}
