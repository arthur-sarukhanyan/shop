<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerInterface;
class CustomerRepository extends ModelRepository implements CustomerInterface
{
    public function __construct()
    {
        parent::__construct(Customer::class);
    }
}
