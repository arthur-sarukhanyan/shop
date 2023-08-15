<?php

namespace App\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static list(array $params)
 * @method static listFiltered(array $params): Collection
 * @method static create(array $data): Model|Collection
 * @method static createMultiple(array $data): Collection
 * @method static find(int $id, array $with = []): Model|null
 * @method static update(int $id, array $data): Model|bool
 * @method static delete(int $id): bool
 * @method static attach(int $modelId, int $relatedModelId, string $relation): bool|Model
 * @method static sync(int $modelId, array $relatedModelIds, string $relation): bool|Model
 * @method static pagination(array $params): array
 * @method static setCategoryPath(int $modelId): void
 * @method static generatePath(int $id): string
 * @method static findByName(string $name, array $with = []): Model
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
