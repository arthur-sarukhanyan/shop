<?php

namespace App\Repositories;

use App\Helpers\ModelFilterHelper;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ModelRepository implements RepositoryInterface
{
    use ModelFilterHelper;

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
        $collection = $this->model->all();
        return $collection;
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): Model|null
    {
        $model = $this->model->where('id', $id)->first();
        return $model;
    }

    /**
     * @param string $column
     * @param string $value
     * @return Collection
     */
    public function findBy(string $column, string $value): Collection
    {
        $collection = $this->model->where($column, $value)->get();
        return $collection;
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

        $updated = $model->update($params);
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
}
