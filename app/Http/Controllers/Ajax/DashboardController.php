<?php

namespace App\Http\Controllers\ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DashboardController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
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

    public function getMenu(Request $request)
    {
        $modelName = $request->model;
        $keyword = addslashes($request->keyword ?? '');
        $repositoryInstance = $this->getRepositoryInstance($modelName);
        $agrument = $this->paginationAgrument($modelName, $keyword);
        $object = $repositoryInstance->pagination(...array_values($agrument));
        return response()->json($object);
    }

    private function paginationAgrument($modelName = '', $keyword = '')
    {

        $modelName = Str::snake($modelName);
        $join = [
            "{$modelName}_language as tb2" => ["tb2.{$modelName}_id", '=', "{$modelName}s.id"],
        ];

        $condition = [
            'keyword' => $keyword,
            'where' => [
                'language_id' => ['=', session('currentLanguage')]
            ]
        ];

        // Kiểm tra xem $modelName có chứa '_catalogue' hay không
        if (strpos($modelName, '_catalogue') === false) {
            $join["{$modelName}_catalogue_{$modelName} as tb3"] = ["tb3.{$modelName}_id", '=', "{$modelName}s.id"];
        }
        $select = ['id', 'name', 'canonical'];

        return [
            'select' =>  $select,
            'condition' => $condition,
            'perpage' => 10,
            'orderBy' => ["{$modelName}s.id" => 'desc'],
            'join' => $join,
            'relations' => [],
            'groupBy' =>  $select,
        ];
    }

    public function findModelObject(Request $request)
    {
        $repository = $this->getRepositoryInstance($request->model);
        $languageTable = Str::snake($request->model) . '_language';
        $object = $repository->findWidgetItem(
            [
                'name' => ['like', '%' . $request->keyword . '%']
            ],
            ['id', 'image'],
            $languageTable,
            $this->currentLanguage
        );

        return response()->json($object);
    }

    public function findPromotionObject(Request $request)
    {
        $modelName = $request->option['model'];
        $repository = $this->getRepositoryInstance($modelName);
        $languageTable = Str::snake($modelName) . '_language';
        $object = $repository->findWidgetItem(
            [
                'name' => ['like', '%' . $request->search . '%']
            ],
            ['id', 'image'],
            $languageTable,
            $this->currentLanguage
        );


        $objectMapped = $object->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->languages->first()->pivot->name
            ];
        });

        return response()->json(array('items' => $objectMapped));
    }

    public function getPromotionConditionValue(Request $request)
    {
        $response = [];
        switch ($request->value) {
            case 'staff_take_care_customer':
                $repositoryInstance = $this->getRepositoryInstance('User');
                $data = $repositoryInstance->all([], ['id', 'fullname'])->toArray();
                break;
            case 'customer_group':
                $repositoryInstance = $this->getRepositoryInstance('CustomerCatalogue');
                $data = $repositoryInstance->all([], ['id', 'name'])->toArray();
                break;
            case 'customer_gender':
                $data = __('general.gender');
                break;
            case 'customer_birthday':
                $data = __('general.day');
                break;
        }
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                $response[] = [
                    'id' => $value['id'],
                    'text' => $value['name'] ?? $value['fullname']
                ];
            }
        }
        return response()->json([
            'data' => $response
        ]);
    }
}
