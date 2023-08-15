<?php

namespace App\Http\Controllers;

use App\Facades\BasketFacade;
use App\Facades\BasketItemFacade;
use App\Facades\OrderFacade;
use App\Http\Requests\Basket\SubmitBasketRequest;
use App\Http\Requests\Basket\UpdateBasketRequest;
use App\Http\Resources\Basket\BasketResource;
use App\Http\Resources\Order\OrderResource;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    /**
     * @param SubmitBasketRequest $request
     * @return OrderResource
     */
    public function submit(SubmitBasketRequest $request): OrderResource
    {
        $token = $request->bearerToken();
        $data = $request->validated();
        if ($token) {
            $userToken = PersonalAccessToken::findToken($token);
            if (!$userToken) {
                throw new NotFoundHttpException();
            }
            $customerId = $userToken->tokenable_id;
        } else {
            $customerId = $data['id'];
            unset($data['id']);
        }

        BasketItemFacade::updateItems($data, $customerId);
        $order = OrderFacade::createFromBasket($customerId);
        return new OrderResource($order);
    }
}
