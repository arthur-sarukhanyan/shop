<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ProductInterface extends ServiceInterface
{
    public function createMultiple(array $data):Collection;
}
