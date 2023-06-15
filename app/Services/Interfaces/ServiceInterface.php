<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \App\Services\BaseService
 */
interface ServiceInterface
{
    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data):Model|Collection;

    /**
     * @param array $params
     * @return Collection
     */
    public function list(array $params = []):Collection;

    /**
     * @param int $id
     * @param array $data
     * @return Model|bool
     */
    public function update(int $id, array $data): Model|bool;

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id):Model|null;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param int $modelId
     * @param int $relatedModelId
     * @param string $relation
     * @return bool|Model
     */
    public function attach(int $modelId, int $relatedModelId, string $relation): bool|Model;

    /**
     * @param int $modelId
     * @param array $relatedModelIds
     * @param string $relation
     * @return bool|Model
     */
    public function sync(int $modelId, array $relatedModelIds, string $relation): bool|Model;
}
