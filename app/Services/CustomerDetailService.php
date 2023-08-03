<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerDetailInterface as RepositoryInterface;
use App\Services\Interfaces\CustomerDetailInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerDetailService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function findByCustomerId(int $id): Model|null
    {
        $item = $this->modelRepository->findOneBy('customer_id', $id);
        return $item;
    }
}
