<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static list(array $params)
 * @method static create(array $data): Model|Collection
 * @method static createMultiple(array $data): Collection
 * @method static pagination(array $params): array
 * @method static find(int $id, array $with = []): Model|null
 * @method static update(int $id, array $data): Model|bool
 * @method static listFiltered(array $params): Collection
 * @method static delete(int $id): bool
 * @method static attach(int $modelId, int $relatedModelId, string $relation): bool|Model
 * @method static sync(int $modelId, array $relatedModelIds, string $relation): bool|Model
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
