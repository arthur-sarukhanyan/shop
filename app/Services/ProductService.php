<?php

namespace App\Services;

use App\Events\CategorySyncEvent;
use App\Facades\ImageFacade;
use App\Repositories\Interfaces\ProductInterface as RepositoryInterface;
use App\Services\Interfaces\ProductInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
                $categoryIds = json_decode($item['category_id'], true);
                parent::sync($created->id, $categoryIds, 'categories');
                CategorySyncEvent::dispatch($created);
            }

            ImageFacade::attachImage($created->id, $this->getType(), $item['image']);
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
}
