<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \App\Services\CategoryService
 */
interface CategoryInterface extends ServiceInterface
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
     * @param int $id
     * @param array $data
     * @return Model|bool
     */
    public function update(int $id, array $data): Model|bool;

    /**
     * @param int $modelId
     * @return void
     */
    public function setCategoryPath(int $modelId): void;

    /**
     * @param int $id
     * @return string|null
     */
    public function generatePath(int $id): string|null;

    /**
     * @param string $name
     * @param array $with
     * @return Model
     */
    public function findByName(string $name, array $with = []): Model;
}
