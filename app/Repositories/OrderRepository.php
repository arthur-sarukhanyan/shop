<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderInterface;
class OrderRepository extends ModelRepository implements OrderInterface
{
    public function __construct()
    {
        parent::__construct(Order::class);
    }

    /**
     * @return string
     */
    public function getLatestNumber(): string
    {
        $latestNumberItem = $this->model->select('number')->orderBy('number', 'DESC')->first();

        if ($latestNumberItem) {
            return $latestNumberItem->number;
        } else {
            return '1';
        }
    }
}
