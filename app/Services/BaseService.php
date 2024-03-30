<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
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

    protected function formatAlbum($payload)
    {
        // Lấy ra payload từ form
        if (isset($payload['album']) && !empty($payload['album'])) {
            $payload['album'] = json_encode($payload['album']);
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
    }

    protected function updateRouter($model)
    {
        $payloadRoute = $this->formatPayloadRoute($model, $this->controllerName);
        $condition = [
            'module_id' => ['=', $model->id],
            'controllers' => ['=', 'App\Http\Controllers\Clients\\' . $this->controllerName]
        ];
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
}
