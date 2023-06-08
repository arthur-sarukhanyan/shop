<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerAuthController extends AuthController
{
    public function getAuthEntity($email): Authenticatable|null
    {
        return Customer::where('email', $email)->first();
    }
}
