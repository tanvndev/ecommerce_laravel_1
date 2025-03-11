<?php

namespace App\Services;

use App\Repositories\Interfaces\CommissionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\MLMServiceInterface;

/**
 * Class MLMService
 * @package App\Services
 */
class MLMService implements MLMServiceInterface
{

    protected $commissionRepository;
    protected $userRepository;

    public function __construct(
        CommissionRepositoryInterface $commissionRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->commissionRepository = $commissionRepository;
        $this->userRepository = $userRepository;
    }
    public function getAllDescendants($userId)
    {
        $user = $this->userRepository->findById($userId);
        $result = [];

        $level1 = $user->children()->with('orders')->get();
        foreach ($level1 as $child) {
            $result[] = [
                'id' => $child->id,
                'name' => $child->fullname,
                'level' => 1,
                'total_sales' => $child->orders->sum(function ($order) {
                    return $order->cart['total'] ?? 0;
                })
            ];

            $level2 = $child->children()->with('orders')->get();
            foreach ($level2 as $grandChild) {
                $result[] = [
                    'id' => $grandChild->id,
                    'name' => $grandChild->fullname,
                    'level' => 2,
                    'total_sales' => $grandChild->orders->sum(function ($order) {
                        return $order->cart['total'] ?? 0;
                    })
                ];

                $level3 = $grandChild->children()->with('orders')->get();
                foreach ($level3 as $greatGrandChild) {
                    $result[] = [
                        'id' => $greatGrandChild->id,
                        'name' => $greatGrandChild->fullname,
                        'level' => 3,
                        'total_sales' => $greatGrandChild->orders->sum(function ($order) {
                            return $order->cart['total'] ?? 0;
                        })
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * Tinh hoa hong kkhi co don hang
     */
    public function calculateCommission($order)
    {
        $user = $order->user;
        $amount = (float) $order->cart['total'];
        $currentParent = $user->parent;
        $level = 1;

        while ($currentParent && $level <= 3) {
            switch ($level) {
                case 1:
                    $commission = $amount * 0.10; // 10%
                    break;
                case 2:
                    $commission = $amount * 0.05; // 5%
                    break;
                case 3:
                    $commission = $amount * 0.03; // 3%
                    break;
            }
            if ($commission > 0) {
                $this->commissionRepository->create([
                    'order_id' => $order->id,
                    'user_id' => $currentParent->id,
                    'amount' => $commission,
                    'level' => $level
                ]);
            }

            $currentParent = $currentParent->parent;
            $level++;
        }
    }

    /**
     * Lay thu nhap cua user
     */
    public function getUserIncome($userId)
    {
        $user = $this->userRepository->findById($userId);

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'total_commission' => $user->commissions()->sum('amount'),
            'commission_details' => $user->commissions()
                ->with('order')
                ->get()
                ->map(function ($commission) {
                    return [
                        'order_id' => $commission->order_id,
                        'order_code' => $commission->order->code,
                        'user_name' => $commission->order->user->fullname,
                        'amount' => $commission->amount,
                        'level' => $commission->level,
                        'created_at' => $commission->created_at
                    ];
                })
        ];

        return $data;
    }
}
