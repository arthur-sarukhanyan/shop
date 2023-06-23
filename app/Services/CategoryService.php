<?php

namespace App\Services;

use App\Events\CategorySyncEvent;
use App\Repositories\Interfaces\CategoryInterface as RepositoryInterface;
use App\Services\Interfaces\CategoryInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends BaseService implements ServiceInterface
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
            $list->push(parent::create($item));
        }

        return $list;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|bool
     */
    public function update(int $id, array $data): Model|bool
    {
        $updated = parent::update($id, $data);
        $item = parent::find($id, ['allProducts']);
        foreach ($item->allProducts as $product) {
            CategorySyncEvent::dispatch($product);
        }

        return $updated;
    }
}
