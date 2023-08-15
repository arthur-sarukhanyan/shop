<?php

namespace App\Http\Controllers\Admin;

use App\Facades\UserFacade;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\View\View;

class AdminAuthController extends AuthController
{
    /**
     * @return View
     */
    public function viewLogin(): View
    {
        return view('auth.login');
    }

    /**
     * @param $email
     * @return Authenticatable|null
     */
    public function getAuthEntity($email): Authenticatable|null
    {
        return UserFacade::findByEmail($email);
    }

    /**
     * @return string
     */
    public function getAuthenticateModel(): string
    {
        return User::class;
    }
}
