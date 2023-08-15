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
                $item = $this->modifyItem($item, $customerId, $basket->id);
                parent::create($item);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
        } finally {
            DB::commit();
        }
    }

    /**
     * @param array $data
     * @param int $customerId
     * @param int $basketId
     * @return array
     */
    public function modifyItem(array $data, int $customerId, int $basketId): array
    {
        $product = ProductFacade::find($data['id']);

        $data['customer_id'] = $customerId;
        $data['name'] = $product->name;
        $data['description'] = $product->description;
        $data['basket_id'] = $basketId;
        $data['price'] = $data['quantity'] * $product->price;
        $data['original_price'] = $product->price;
        $data['product_id'] = $data['id'];
        unset($data['id']);

        return  $data;
    }
}
