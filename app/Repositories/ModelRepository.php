<?php

namespace App\Repositories;

use App\Helpers\ModelFilterHelper;
use App\Helpers\PaginationHelper;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ModelRepository implements RepositoryInterface
{
    use ModelFilterHelper, PaginationHelper;

    protected Model $model;

    public function __construct($model)
    {
        $this->model = new $model();
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params): Collection
    {
        $collection = $this->model->with($params)->get();
        return $collection;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $count = $this->model->count();
        return $count;
    }

    /**
     * @param int $id
     * @param array $with
     * @return Model|null
     */
    public function find(int $id, array $with = []): Model|null
    {
        $model = $this->model->where('id', $id)->with($with)->first();
        return $model;
    }

    /**
     * @param string $column
     * @param string $value
     * @param array $with
     * @return Collection
     */
    public function findBy(string $column, string $value, array $with = []): Collection
    {
        $collection = $this->model->where($column, $value)->with($with)->get();
        return $collection;
    }

    /**
     * @param string $column
     * @param string $value
     * @param array $with
     * @return Model|null
     */
    public function findOneBy(string $column, string $value, array $with = []): Model|null
    {
        $item = $this->model->where($column, $value)->with($with)->first();
        return $item;
    }

    /**
     * @param array $conditions
     * @return Collection
     */
    public function findByConditions(array $conditions): Collection
    {
        $query = $this->model->newQuery();
        foreach ($conditions as $condition) {
            $query->where($condition->column, $condition->value);
        }

        $collection = $query->get();
        return $collection;
    }

    /**
     * @param array $params
     * @return Model
     */
    public function create(array $params): Model
    {
        $model = $this->model->create($params);
        return $model;
    }

    /**
     * @param int $id
     * @param array $params
     * @return Model|bool
     */
    public function update(int $id, array $params): Model|bool
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }

        $updated = tap($model, function ($model) use ($params) {
            $model->update($params);
        });

        return $updated;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }

        $model->delete();
        return true;
    }

    /**
     * @param int $id
     * @param int $relationId
     * @param string $relationName
     * @param array $params
     * @return Model|bool|null
     */
    public function attach(int $id, int $relationId, string $relationName, array $params = []): Model|bool|null
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }

        $model->$relationName()->attach($relationId, $params);
        return $model;
    }

    /**
     * @param int $id
     * @param int $relationId
     * @param string $relationName
     * @return Model|bool|null
     */
    public function detach(int $id, int $relationId, string $relationName): Model|bool|null
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }

        $model->$relationName()->detach($relationId);
        return $model;
    }

    /**
     * @param int $id
     * @param array $relationIds
     * @param string $relationName
     * @return Model|bool|null
     */
    public function sync(int $id, array $relationIds, string $relationName): Model|bool|null
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }

        $model->$relationName()->sync($relationIds);
        return $model;
    }

    /**
     * @param string $column
     * @param string $value
     * @return void
     */
    public function deleteBy(string $column, string $value): void
    {
        $this->model->where($column, $value)->delete();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->model::class;
    }

    /**
     * Return result based on params
     *
     * @param array $params
     * @return Collection
     */
    public function listFiltered(array $params): Collection
    {
        $query = $this->model->newQuery();
        $query = $this->generate($query, $params);

        return $query->get();
    }

    /**
     * Return count based on params
     *
     * @param array $params
     * @return int
     */
    public function countFiltered(array $params): int
    {
        $query = $this->model->newQuery();
        $query = $this->generate($query, $params, true);

        return $query->count();
    }

    /**
     * @param array $params
     * @return array
     */
    public function getPagination(array $params): array
    {
        $params = $this->updateParams($params);

        if ($this->needsFilteredCount($params)) {
            $count = $this->countFiltered($params);
        } else {
            $count = $this->count();
        }

        $pagination = $this->createPagination($params, $count);
        return $pagination;
    }
}
