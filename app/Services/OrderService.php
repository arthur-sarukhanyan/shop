<?php

namespace App\Services;

use App\Facades\BasketFacade;
use App\Facades\BasketItemFacade;
use App\Facades\OrderDetailFacade;
use App\Repositories\Interfaces\OrderInterface as RepositoryInterface;
use App\Services\Interfaces\OrderInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param int $customerId
     * @return Model
     */
    public function createFromBasket(int $customerId): Model
    {
        DB::beginTransaction();
        $price = 0;
        $originalPrice = 0;

        try {
            $basket = BasketFacade::findByCustomer($customerId);
            $orderData = [
                'number' => $this->getOrderNumber(),
                'customer_id' => $customerId,
                'price' => $price,
                'original_price' => $originalPrice,
            ];

            $order = parent::create($orderData);
            foreach ($basket->items as $item) {
                OrderDetailFacade::createOrderDetailsFromBasket($item, $order->id);
                $price += $item->price;
                $originalPrice += $item->price;
            }

            $order = parent::update($order->id, ['price' => $price, 'original_price' => $originalPrice]);

            BasketItemFacade::updateItems([], $customerId);
        } catch (\Exception $exception) {
            DB::rollBack();
        } finally {
            DB::commit();
        }

        return $order;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        $latestNumber = $this->modelRepository->getLatestNumber();
        $latestNumber = intval($latestNumber) + 1;
        return str_pad($latestNumber, 6, '0', STR_PAD_LEFT);
    }
}
