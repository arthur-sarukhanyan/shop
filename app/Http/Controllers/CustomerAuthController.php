<?php

namespace App\Http\Controllers;

use App\Facades\CustomerFacade;
use App\Models\Customer;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerAuthController extends AuthController
{
    /**
     * @param $email
     * @return Authenticatable|null
     */
    public function getAuthEntity($email): Authenticatable|null
    {
        return CustomerFacade::findByEmail($email);
    }

    /**
     * @return string
     */
    public function getAuthenticateModel(): string
    {
        return Customer::class;
    }
}
