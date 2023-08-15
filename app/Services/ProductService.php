<?php

namespace App\Services;

use App\Facades\ImageFacade;
use App\Repositories\Interfaces\ProductInterface as RepositoryInterface;
use App\Services\Interfaces\ProductInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param array $data
     * @return Model|Collection
     */
    public function create(array $data): Model|Collection
    {
        if (isset($data['list'])) {
            return $this->createMultiple($data['list']);
        }

        return parent::create($data);
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function createMultiple(array $data): Collection
    {
        $list = new Collection();

        foreach ($data as $item) {
            $created = parent::create($item);
            if (isset($item['category_id'])) {
                parent::sync($created->id, $item['category_id'], 'categories');
            }

            if (isset($item['image'])) {
                ImageFacade::attachImage($created->id, $this->getType(), $item['image']);
            }
            $list->push($created);
        }

        return $list;
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function list(array $params = []): Collection
    {
        return parent::listFiltered($params);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|bool
     */
    public function update(int $id, array $data): Model|bool
    {
        $updated = parent::update($id, $data);
        if (isset($data['category_id'])) {
            parent::sync($updated->id, $data['category_id'], 'categories');
        }

        if (isset($data['filter_id'])) {
            parent::sync($updated->id, $data['filter_id'], 'filters');
        }

        if (isset($data['image'])) {
            ImageFacade::attachImage($updated->id, $this->getType(), $data['image']);
        }

        return $updated;
    }
}
