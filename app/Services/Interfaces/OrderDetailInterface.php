<?php

namespace App\Services\Interfaces;
use App\Models\BasketItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface OrderDetailInterface extends ServiceInterface
{
    /**
     * @param BasketItem $item
     * @param int $orderId
     * @return void
     */
    public function createOrderDetailsFromBasket(BasketItem $item, int $orderId): void;
}
