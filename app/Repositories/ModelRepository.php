<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ModelRepository implements RepositoryInterface
{
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
     * @return string
     */
    public function getType(): string
    {
        return $this->model::class;
    }
}
