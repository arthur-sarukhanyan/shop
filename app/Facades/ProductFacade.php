<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static list(array $params)
 * @method static create(array $data): Model|Collection
 * @method static createMultiple(array $data): Collection
 *
 * @see \App\Services\ProductService
 */
class ProductFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'ProductService';
    }
}
