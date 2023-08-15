<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;

/**
 * @see \App\Services\UserService
 */
interface UserInterface extends ServiceInterface
{
    /**
     * @param string $email
     * @return Model
     */
    public function findByEmail(string $email): Model;
}
