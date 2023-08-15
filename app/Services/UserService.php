<?php

namespace App\Services;

use App\Repositories\Interfaces\UserInterface as RepositoryInterface;
use App\Services\Interfaces\UserInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends BaseService implements ServiceInterface
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
        $item = $this->modelRepository->findOneBy('email', $email);
        if (!$item) {
            throw new ModelNotFoundException();
        }

        return $item;
    }
}
