<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminAuthController extends AuthController
{
    function getAuthEntity($email): Authenticatable|null
    {
        return User::where('email', $email)->first();
    }
}
