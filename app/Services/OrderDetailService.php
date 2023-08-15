<?php

namespace App\Services;

use App\Models\BasketItem;
use App\Repositories\Interfaces\OrderDetailInterface as RepositoryInterface;
use App\Services\Interfaces\OrderDetailInterface as ServiceInterface;

class OrderDetailService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param BasketItem $item
     * @param int $orderId
     * @return void
     */
    public function createOrderDetailsFromBasket(BasketItem $item, int $orderId): void
    {
        $detailData = [
            'quantity' => $item->quantity,
            'name' => $item->name,
            'description' => $item->description,
            'price' => $item->price,
            'original_price' => $item->original_price,
            'order_id' => $orderId,
            'product_id' => $item->product_id,
        ];

        parent::create($detailData);
    }
}
