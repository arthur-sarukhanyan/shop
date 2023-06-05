<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductInterface
{
    private Model $model;

    public function __construct()
    {
        $this->model = new Product();
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
        $model = $this->model::create($params);
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
