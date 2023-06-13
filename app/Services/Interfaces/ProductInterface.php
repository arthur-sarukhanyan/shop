<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * @see \App\Services\ProductService
 */
interface ProductInterface extends ServiceInterface
{
    public function createMultiple(array $data):Collection;
}
