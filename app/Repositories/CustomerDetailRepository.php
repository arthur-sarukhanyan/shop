<?php

namespace App\Repositories;

use App\Models\CustomerDetail;
use App\Repositories\Interfaces\CustomerDetailInterface;
class CustomerDetailRepository extends ModelRepository implements CustomerDetailInterface
{
    public function __construct()
    {
        parent::__construct(CustomerDetail::class);
    }
}
