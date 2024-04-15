<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $currentLanguage;
    protected $nestedset;

    public function __construct()
    {
        // Lấy ra ngôn ngữ hiện tại và gán vào session
        $this->middleware(function ($request, $next) {
            $languageId = app(LanguageRepository::class)->getCurrentLanguage();
            $this->currentLanguage = $languageId;
            session(['currentLanguage' => $languageId]);
            return $next($request);
        });
    }

    protected function getToastMessage($module, $key, $action)
    {
        $configMessage = __("messages.$module.$action");
        return $configMessage[$key] ?? null;
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
