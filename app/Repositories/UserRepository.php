<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;

class UserRepository extends ModelRepository implements UserInterface
{
    public function __construct()
    {
        parent::__construct(User::class);
    }
}
