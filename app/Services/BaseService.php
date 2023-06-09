<?php

namespace App\Services;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseService implements ServiceInterface
{
    protected RepositoryInterface $modelRepository;

    public function __construct(RepositoryInterface $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    public function create(array $data): Model|Collection
    {
        $created = $this->modelRepository->create($data);
        return $created;
    }

    public function list(array $params = []): Collection
    {
        $list = $this->modelRepository->all($params);
        return $list;
    }

    public function update(array $data): Model
    {
        // TODO: Implement update() method.
    }

    public function one(int $id): Model
    {
        // TODO: Implement one() method.
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }
}
