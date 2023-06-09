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
}
