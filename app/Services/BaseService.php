<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    protected $nestedset;
    protected $routerRepository;
    protected $controllerName;

    public function __construct()
    {
        $this->routerRepository = app(RouterRepository::class);
    }


    protected function calculateNestedSet()
    {
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }


    protected function formatJson($payload, $inputName)
    {
        // Lấy ra payload từ form
        if (isset($payload[$inputName]) && !empty($payload[$inputName])) {
            $payload[$inputName] = json_encode($payload[$inputName]);
        }
        return $payload;
    }

    protected function formatPayloadRoute($model)
    {
        $router = [
            'canonical' => Str::slug(request('canonical')),
            'module_id' => $model->id,
            'language_id' => session('currentLanguage'),
            'controllers' => 'App\Http\Controllers\Clients\\' . $this->controllerName
        ];
        return $router;
    }

    protected function createRouter($model)
    {
        $payloadRoute = $this->formatPayloadRoute($model, $this->controllerName);
        return $this->routerRepository->create($payloadRoute);
        // dd($payloadRoute);
    }

    protected function updateRouter($model)
    {
        $payloadRoute = $this->formatPayloadRoute($model, $this->controllerName);
        $condition = [
            'module_id' => ['=', $model->id],
            'controllers' => ['=', 'App\Http\Controllers\Clients\\' . $this->controllerName],
            'language_id' => ['=', session('currentLanguage')]
        ];
        // $this->routerRepository->forceDeleteByWhere($condition);
        // return $this->routerRepository->create($payloadRoute);
        return $this->routerRepository->updateByWhere($condition, $payloadRoute);
    }

    protected function deleteRouter($id)
    {
        $condition = [
            'module_id' => ['=', $id],
            'controllers' => ['=', 'App\Http\Controllers\Clients\\' . $this->controllerName]
        ];

        return $this->routerRepository->deleteByWhere($condition);
    }

    public function updateStatus()
    {
        DB::beginTransaction();
        try {
            $modelName = lcfirst(request('model')) . 'Repository';

            $payload[request('field')] = request('value') == 1 ? 0 : 1;
            $update =  $this->{$modelName}->update(request('modelId'), $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function updateStatusAll()
    {
        DB::beginTransaction();
        try {
            $modelName = lcfirst(request('model')) . 'Repository';

            $payload[request('field')] = request('value');
            $update =  $this->{$modelName}->updateByWhereIn('id', request('id'), $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    protected function getServiceInstance($modelName)
    {
        $serviceInterfaceNameSpace = 'App\Services\Interfaces\\' . ucfirst($modelName) . 'ServiceInterface';
        if (interface_exists($serviceInterfaceNameSpace)) {
            // hàm app() giúp truy cập các đối tượng đã đăng ký trong container
            return app($serviceInterfaceNameSpace);
        }
        return null;
    }

    protected function getRepositoryInstance($modelName)
    {
        $repositoryInterfaceNameSpace = 'App\Repositories\Interfaces\\' . ucfirst($modelName) . 'RepositoryInterface';
        if (interface_exists($repositoryInterfaceNameSpace)) {
            // hàm app() giúp truy cập các đối tượng đã đăng ký trong container
            return app($repositoryInterfaceNameSpace);
        }
        return null;
    }
}
