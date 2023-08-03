<?php

namespace App\Exceptions;

use Exception;

class ProductMismatchException extends Exception
{
    protected $message = 'Product is not match with DB product';
}
