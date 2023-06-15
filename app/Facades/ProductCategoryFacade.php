<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static list(array $params)
 * @method static create(array $data): Model|Collection
 * @method static setCategoryPath(int $modelId): void
 *
 * @see \App\Services\ProductCategoryService
 */
class ProductCategoryFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'ProductCategoryService';
    }
}
