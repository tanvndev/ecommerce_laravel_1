<?php

namespace App\Services\Interfaces;

/**
 * Interface MLMServiceInterface
 * @package App\Services\Interfaces
 */
interface MLMServiceInterface
{
    public function getAllDescendants($userId);
    public function calculateCommission($order);
    public function getUserIncome($userId);
}
