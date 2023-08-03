<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * @see \App\Repositories\CategoryRepository
 */
interface CategoryInterface extends RepositoryInterface
{
    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params): Collection;
}
