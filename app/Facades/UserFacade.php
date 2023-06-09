<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static list(array $params)
 * @method static create(array $data): Model|Collection
 *
 * @see \App\Services\UserService
 */
class UserFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'UserService';
    }
}
