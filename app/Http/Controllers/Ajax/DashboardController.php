<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function changeStatus(Request $request)
    {
        // Lấy ra service tương ứng
        $serviceInstance = $this->getServiceInstance($request->model);

        // Cập nhập trạng thái
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

    public function changeStatusAll(Request $request)
    {
        // Lấy ra service tương ứng
        $serviceInstance = $this->getServiceInstance($request->model);

        // Cập nhập trạng thái
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

    private function getServiceInstance($modelName)
    {
        $serviceInterfaceNameSpace = 'App\Services\Interfaces\\' . ucfirst($modelName) . 'ServiceInterface';
        if (interface_exists($serviceInterfaceNameSpace)) {
            // hàm app() giúp truy cập các đối tượng đã đăng ký trong container
            return app($serviceInterfaceNameSpace);
        }
        return null;
    }
}
