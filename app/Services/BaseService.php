<?php

namespace App\Services;

use App\Repositories\Interfaces\RepositoryInterface;
use App\Services\Interfaces\ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @param array $params
     * @return Collection
     */
    public function listFiltered(array $params): Collection
    {
        return $this->modelRepository->listFiltered($params);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|bool
     */
    public function update(int $id, array $data): Model|bool
    {
        $updated = $this->modelRepository->update($id, $data);
        if (!$updated) {
            throw new ModelNotFoundException();
        }

        return $updated;
    }

    /**
     * @param int $id
     * @param array $with
     * @return Model|null
     */
    public function find(int $id, array $with = []): Model|null
    {
        $item = $this->modelRepository->find($id, $with);
        if (!$item) {
            throw new ModelNotFoundException();
        }

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

    /**
     * @param array $params
     * @return array
     */
    public function pagination(array $params): array
    {
        return $this->modelRepository->getPagination($params);
    }
}
