<?php

namespace App\Services;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseService implements ServiceInterface
{
    protected RepositoryInterface $modelRepository;

    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param array $data
     * @return Model|Collection
     */
    public function create(array $data): Model|Collection
    {
        $created = $this->modelRepository->create($data);
        return $created;
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function list(array $params = []): Collection
    {
        $list = $this->modelRepository->all($params);
        return $list;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|bool
     */
    public function update(int $id, array $data): Model|bool
    {
        $updated = $this->modelRepository->update($id, $data);
        return $updated;
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): Model|null
    {
        $item = $this->modelRepository->find($id);
        return $item;
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->modelRepository->getType();
    }

    /**
     * @param int $modelId
     * @param int $relatedModelId
     * @param string $relation
     * @return bool|Model
     */
    public function attach(int $modelId, int $relatedModelId, string $relation): bool|Model
    {
        return $this->modelRepository->attach($modelId, $relatedModelId, $relation);
    }

    /**
     * @param int $modelId
     * @param array $relatedModelIds
     * @param string $relation
     * @return bool|Model
     */
    public function sync(int $modelId, array $relatedModelIds, string $relation): bool|Model
    {
        return $this->modelRepository->sync($modelId, $relatedModelIds, $relation);
    }
}
