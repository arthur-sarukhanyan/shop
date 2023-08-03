<?php

namespace App\Services\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface CustomerInterface extends ServiceInterface
{
    /**
     * @param string $email
     * @return Model
     */
    public function findByEmail(string $email): Model;

    /**
     * @param int|null $id
     * @param array $data
     * @return Model
     */
    public function updateDetails(int|null $id, array $data): Model;

    /**
     * @return int
     */
    public function createDummyCustomer(): int;
}
