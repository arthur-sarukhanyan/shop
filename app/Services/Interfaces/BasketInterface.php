<?php

namespace App\Services\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface BasketInterface extends ServiceInterface
{
    /**
     * @param int $customerId
     * @return Model
     */
    public function findByCustomer(int $customerId): Model;
}
