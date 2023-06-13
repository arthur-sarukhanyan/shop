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
     * @param array $data
     * @return Model
     */
    public function update(array $data):Model;

    /**
     * @param int $id
     * @return Model
     */
    public function one(int $id):Model;

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
}
