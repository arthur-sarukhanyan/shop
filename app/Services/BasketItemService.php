<?php

namespace App\Services;

use App\Facades\BasketFacade;
use App\Facades\ProductFacade;
use App\Repositories\Interfaces\BasketItemInterface as RepositoryInterface;
use App\Services\Interfaces\BasketItemInterface as ServiceInterface;
use Illuminate\Support\Facades\DB;

class BasketItemService extends BaseService implements ServiceInterface
{
    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param array $data
     * @param int $customerId
     * @return void
     */
    public function updateItems(array $data, int $customerId): void
    {
        $basket = BasketFacade::findByCustomer($customerId);

        DB::beginTransaction();
        try {
            $this->modelRepository->deleteBy('basket_id', $basket->id);
            if (!isset($data['items'])) {
                return;
            }

            foreach ($data['items'] as $item) {
                $product = ProductFacade::find($item['id']);
                $item['customer_id'] = $customerId;
                $item['name'] = $product->name;
                $item['description'] = $product->description;
                $item['basket_id'] = $basket->id;
                $item['price'] = $item['quantity'] * $product->price;
                $item['original_price'] = $item['price'];
                $item['product_id'] = $item['id'];
                unset($item['id']);
                parent::create($item);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
        } finally {
            DB::commit();
        }
    }
}
