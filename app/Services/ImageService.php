<?php

namespace App\Services;

use App\Repositories\Interfaces\ImageInterface as RepositoryInterface;
use App\Services\Interfaces\ImageInterface as ServiceInterface;
class ImageService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }
}
