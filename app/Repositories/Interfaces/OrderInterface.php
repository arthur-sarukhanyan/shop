<?php

namespace App\Repositories\Interfaces;
interface OrderInterface extends RepositoryInterface
{
    /**
     * @return string
     */
    public function getLatestNumber(): string;
}
