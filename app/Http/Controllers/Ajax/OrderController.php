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

    public function update()
    {
    }
}
