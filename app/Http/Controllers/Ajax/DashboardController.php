<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function changeStatus(Request $request)
    {
        $serviceInterfaceNameSpace = 'App\Services\Interfaces\\' . ucfirst($request->model) . 'ServiceInterface';
        if (interface_exists($serviceInterfaceNameSpace)) {
            // hàm app() giúp truy cập các đối tượng đã đăng ký trong container
            $serviceInstance = app($serviceInterfaceNameSpace);
            $updateStatus = $serviceInstance->updateStatus();
            if ($updateStatus) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Cập nhập trạng thái thành công.'
                ]);
            }

            return response()->json([
                'status' => 0,
                'message' => 'Cập nhập trạng thái thất bại.'
            ]);
        }
    }

    public function changeStatusAll(Request $request)
    {
        $serviceInterfaceNameSpace = 'App\Services\Interfaces\\' . ucfirst($request->model) . 'ServiceInterface';
        if (interface_exists($serviceInterfaceNameSpace)) {
            // hàm app() giúp truy cập các đối tượng đã đăng ký trong container
            $serviceInstance = app($serviceInterfaceNameSpace);
            $updateStatus = $serviceInstance->updateStatusAll();
            if ($updateStatus) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Cập nhập trạng thái thành công.'
                ]);
            }

            return response()->json([
                'status' => 0,
                'message' => 'Cập nhập trạng thái thất bại.'
            ]);
        }
    }
}
