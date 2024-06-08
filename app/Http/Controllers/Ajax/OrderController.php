<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\OrderServiceInterface as OrderService;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(
        OrderService $orderService
    ) {
        parent::__construct();

        $this->orderService = $orderService;
    }

    public function update($id)
    {
        $successMessage = $this->getToastMessage('order', 'success', 'detail');
        $errorMessage = $this->getToastMessage('order', 'error', 'detail');

        $response = $this->orderService->update($id);
        if ($response !== false) {
            return response()->json([
                'type' => 'success',
                'message' => $successMessage,
            ]);
        }

        return response()->json([
            'type' => 'error',
            'message' => $errorMessage,
        ]);
    }
}
