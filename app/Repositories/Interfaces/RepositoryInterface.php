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
     * @return int
     */
    public function count(): int;

    /**
     * @param int $id
     * @param array $with
     * @return Model|null
     */
    public function find(int $id, array $with = []): Model|null;

    /**
     * @param string $column
     * @param string $value
     * @param array $with
     * @return Collection
     */
    public function findBy(string $column, string $value, array $with = []): Collection;

    /**
     * @param string $column
     * @param string $value
     * @param array $with
     * @return Model|null
     */
    public function findOneBy(string $column, string $value, array $with = []): Model|null;

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
     * @param string $column
     * @param string $value
     * @return void
     */
    public function deleteBy(string $column, string $value): void;

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

    /**
     * Return count based on params
     *
     * @param array $params
     * @return int
     */
    public function countFiltered(array $params): int;

    /**
     * @param array $params
     * @return array
     */
    public function getPagination(array $params): array;
}
