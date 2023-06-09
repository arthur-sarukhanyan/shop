<?php

namespace App\Services;

use App\Repositories\Interfaces\UserInterface as RepositoryInterface;
use App\Services\Interfaces\UserInterface as ServiceInterface;

class UserService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }
}
