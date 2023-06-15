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
     * @param string $column
     * @param string $value
     * @return Collection
     */
    public function findBy(string $column, string $value): Collection;

    /**
     * @param array $conditions
     * @return Collection
     */
    public function findByConditions(array $conditions): Collection;

    /**
     * @param array $params
     * @return Model
     */
    public function create(Array $params):Model;

    /**
     * @param int $id
     * @param array $params
     * @return Model|bool
     */
    public function update(int $id, array $params): Model|bool;

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
     * @param int $id
     * @param array $relationIds
     * @param string $relationName
     * @return Model|bool|null
     */
    public function sync(int $id, array $relationIds, string $relationName): Model|bool|null;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * Return result based on params
     *
     * @param array $params
     * @return Collection
     */
    public function listFiltered(array $params): Collection;
}
