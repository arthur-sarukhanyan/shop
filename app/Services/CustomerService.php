<?php

namespace App\Services;

use App\Facades\CustomerDetailFacade;
use App\Repositories\Interfaces\CustomerInterface as RepositoryInterface;
use App\Services\Interfaces\CustomerInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\HigherOrderCollectionProxy;

class CustomerService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param string $email
     * @return Model
     */
    public function findByEmail(string $email): Model
    {
        $item = $this->modelRepository->findOneBy('email', $email, ['details']);
        if (!$item) {
            throw new ModelNotFoundException();
        }

        return $item;
    }

    /**
     * @param int|null $id
     * @param array $data
     * @return Model
     */
    public function updateDetails(int|null $id, array $data): Model
    {
        if (!$id) {
            $id = $this->createDummyCustomer();
        }

        $details = CustomerDetailFacade::findByCustomerId($id);
        if ($details) {
            CustomerDetailFacade::update($details->id, $data);
        } else {
            $data['customer_id'] = $id;
            CustomerDetailFacade::create($data);
        }

        return $this->find($id, ['details']);
    }

    /**
     * @return int
     */
    public function createDummyCustomer(): int
    {
        $created = $this->create([]);
        return $created->id;
    }
}
