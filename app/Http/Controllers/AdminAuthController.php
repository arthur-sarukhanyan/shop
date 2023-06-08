<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class AdminAuthController extends AuthController
{
    public function viewLogin()
    {
        return view('auth.login');
    }

    public function getAuthEntity($email): Authenticatable|null
    {
        return User::where('email', $email)->first();
    }
}
