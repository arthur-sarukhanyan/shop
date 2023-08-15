<?php

namespace App\Services\Interfaces;
interface BasketItemInterface extends ServiceInterface
{
    /**
     * @param array $data
     * @param int $customerId
     * @return void
     */
    public function updateItems(array $data, int $customerId): void;
}
