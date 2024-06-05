<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrderById($id);
}
