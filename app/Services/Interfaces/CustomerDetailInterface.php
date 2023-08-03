<?php

namespace App\Services\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface CustomerDetailInterface extends ServiceInterface
{
    /**
     * @param int $id
     * @return Model|null
     */
    public function findByCustomerId(int $id): Model|null;
}
