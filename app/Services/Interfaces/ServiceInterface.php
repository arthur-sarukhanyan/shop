<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ServiceInterface
{
    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data):Model|Collection;

    /**
     * @param array $params
     * @return Collection
     */
    public function list(array $params = []):Collection;

    /**
     * @param array $data
     * @return Model
     */
    public function update(array $data):Model;

    /**
     * @param int $id
     * @return Model
     */
    public function one(int $id):Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool;
}
