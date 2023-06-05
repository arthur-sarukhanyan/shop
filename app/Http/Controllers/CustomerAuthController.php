<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends AuthController
{
    function getAuthEntity($email): Authenticatable|null
    {
        return Customer::where('email', $email)->first();
    }
}
