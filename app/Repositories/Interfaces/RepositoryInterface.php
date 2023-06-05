<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @param array $params
     * @return Collection
     */
    public function all(Array $params):Collection;

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id):Model|null;

    /**
     * @param array $params
     * @return Model
     */
    public function create(Array $params):Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool;
}
