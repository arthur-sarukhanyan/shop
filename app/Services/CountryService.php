<?php

namespace App\Services;

use App\Repositories\Interfaces\CountryInterface as RepositoryInterface;
use App\Services\Interfaces\CountryInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Model;

class CountryService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }
}
