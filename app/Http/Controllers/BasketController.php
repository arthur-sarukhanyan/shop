<?php

namespace App\Http\Controllers;

use App\Facades\BasketFacade;
use App\Facades\BasketItemFacade;
use App\Http\Requests\Basket\UpdateBasketRequest;
use App\Http\Resources\Basket\BasketResource;

class BasketController extends Controller
{
    /**
     * @return BasketResource
     */
    public function one(): BasketResource
    {
        $item = BasketFacade::findByCustomer(auth()->user()->id);
        return new BasketResource($item);
    }

    /**
     * @param UpdateBasketRequest $request
     * @return BasketResource
     */
    public function update(UpdateBasketRequest $request): BasketResource
    {
        $data = $request->validated();
        BasketItemFacade::updateItems($data, auth()->user()->id);
        $item = BasketFacade::findByCustomer(auth()->user()->id);
        return new BasketResource($item);
    }
}
