<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryInterface as RepositoryInterface;
use App\Services\Interfaces\CategoryInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param array $data
     * @return Model|Collection
     */
    public function create(array $data): Model|Collection
    {
        if (isset($data['list'])) {
            return $this->createMultiple($data['list']);
        }

        return parent::create($data);
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function createMultiple(array $data): Collection
    {
        $list = new Collection();

        foreach ($data as $item) {
            $list->push(parent::create($item));
        }

        return $list;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|bool
     */
    public function update(int $id, array $data): Model|bool
    {
        $updated = parent::update($id, $data);
        return $updated;
    }

    /**
     * @param int $modelId
     * @return void
     */
    public function setCategoryPath(int $modelId): void
    {
        $path = $this->generatePath($modelId);
        $data = ['path' => $path];
        $this->modelRepository->update($modelId, $data);
    }

    /**
     * @param int $id
     * @return string|null
     */
    public function generatePath(int $id): string|null
    {
        $category = parent::find($id);
        if (!$category->parent_id) {
            return null;
        }

        $path = '|';

        while ($category->parent_id) {
            $path .= $category->parent_id . '|';
            $category = parent::find($category->parent_id);
        }

        return $path;
    }

    /**
     * @param string $name
     * @param array $with
     * @return Model
     */
    public function findByName(string $name, array $with = []): Model
    {
        $category = $this->modelRepository->findOneBy('name', $name, $with);
        if (!$category) {
            throw new ModelNotFoundException();
        }

        return $category;
    }
}
