<?php

namespace App\Services;

use App\Repositories\Interfaces\FilterGroupInterface as RepositoryInterface;
use App\Services\Interfaces\FilterGroupInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FilterGroupService extends BaseService implements ServiceInterface
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
}
