<?php

namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Collection;

interface CountryInterface extends RepositoryInterface
{
    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params): Collection;
}
