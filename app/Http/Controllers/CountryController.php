<?php

namespace App\Http\Controllers;

use App\Facades\CountryFacade;
use App\Http\Resources\Country\ListCountryResource;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * @return ListCountryResource
     */
    public function list(): ListCountryResource
    {
        $list = CountryFacade::list([]);
        return new ListCountryResource($list);
    }
}
