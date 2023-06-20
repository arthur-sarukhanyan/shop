<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \App\Services\ProductService
 */
interface ProductInterface extends ServiceInterface
{
    /**
     * @param array $data
     * @return Model|Collection
     */
    public function create(array $data): Model|Collection;

    /**
     * @param array $data
     * @return Collection
     */
    public function createMultiple(array $data): Collection;

    /**
     * @param array $params
     * @return Collection
     */
    public function list(array $params = []): Collection;
}
