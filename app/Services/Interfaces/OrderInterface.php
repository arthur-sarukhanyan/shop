<?php

namespace App\Services\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface OrderInterface extends ServiceInterface
{
    /**
     * @return string
     */
    public function getOrderNumber(): string;

    /**
     * @param int $customerId
     * @return Model
     */
    public function createFromBasket(int $customerId): Model;
}
