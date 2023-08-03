<?php

namespace App\Services;

use App\Repositories\Interfaces\BasketInterface as RepositoryInterface;
use App\Services\Interfaces\BasketInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BasketService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param int $customerId
     * @return Model
     */
    public function findByCustomer(int $customerId): Model
    {
        $item = $this->modelRepository->findOneBy('customer_id', $customerId, ['items']);

        if (!$item) {
            parent::create(['customer_id' => $customerId]);
            $item = $this->modelRepository->findOneBy('customer_id', $customerId, ['items']);
        }

        return $item;
    }
}
