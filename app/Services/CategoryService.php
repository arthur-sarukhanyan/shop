<?php

namespace App\Services;

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
            $list->push(parent::create($item));
        }

        return $list;
    }

    public function listFiltered(array $params)
    {
        return $this->modelRepository->listFiltered($params);
    }
}
