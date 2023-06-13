<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \App\Repositories\ModelRepository
 */
interface RepositoryInterface
{
    /**
     * @param array $params
     * @return Collection
     */
    public function all(Array $params):Collection;

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id):Model|null;

    /**
     * @param array $params
     * @return Model
     */
    public function create(Array $params):Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool;

    /**
     * @param int $id
     * @param int $relationId
     * @param string $relationName
     * @param array $params
     * @return Model|bool|null
     */
    public function attach(int $id, int $relationId, string $relationName, array $params = []): Model|bool|null;

    /**
     * @param int $id
     * @param int $relationId
     * @param string $relationName
     * @return Model|bool|null
     */
    public function detach(int $id, int $relationId, string $relationName): Model|bool|null;

    /**
     * @return string
     */
    public function getType(): string;
}
