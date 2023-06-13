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

    public function create(array $data): Model|Collection
    {
        if (isset($data['list'])) {
            return $this->createMultiple($data['list']);
        }

        return parent::create($data);
    }

    public function createMultiple(array $data): Collection
    {
        $list = new Collection();

        foreach ($data as $item) {
            $created = parent::create($item);

            ImageFacade::attachImage($created->id, $this->getType(), $item['image']);
            $list->push($created);
        }

        return $list;
    }
}
