<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ResponseCreator
{
    public static function prepare($data, $resourceClass)
    {
        $isAjaxRequest = request()->expectsJson();
        if ($isAjaxRequest) {

        } else {

        }
    }
}
