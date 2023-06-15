<?php

namespace App\Services\Interfaces;
interface ProductCategoryInterface extends ServiceInterface
{
    /**
     * @param int $modelId
     * @return void
     */
    public function setCategoryPath(int $modelId): void;
}
