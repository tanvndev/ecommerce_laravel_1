<?php

namespace App\Services\Interfaces;

/**
 * Interface OrderServiceInterface
 * @package App\Services\Interfaces
 */
interface OrderServiceInterface
{
    public function paginate();
    public function update($id);
    public function updatePayment($id, $payload);
}
