<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static list(array $params)
 * @method static create(array $data): Model|Collection
 * @method static listFiltered(array $params): Collection
 * @method static update(int $id, array $data): Model|bool
 * @method static find(int $id, array $with = []): Model|null
 * @method static delete(int $id): bool
 * @method static attach(int $modelId, int $relatedModelId, string $relation): bool|Model
 * @method static sync(int $modelId, array $relatedModelIds, string $relation): bool|Model
 * @method static pagination(array $params): array
 * @method static findByCustomer(int $customerId): Model
 *
 * @see \App\Services\BasketService
 */
class BasketFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'BasketService';
    }
}
