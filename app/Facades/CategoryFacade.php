<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static list(array $params)
 * @method static listFiltered(array $params): Collection
 * @method static create(array $data): Model|Collection
 * @method static createMultiple(array $data): Collection
 *
 * @see \App\Services\CategoryService
 */
class CategoryFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'CategoryService';
    }
}
