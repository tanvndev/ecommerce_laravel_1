<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;


class HomeController extends Controller
{
    protected $routerRepository;

    public function __construct()
    {
        parent::__construct();
        $this->routerRepository = app(RouterRepository::class);
    }
    public function index($canonical = '')
    {
        $router = $this->routerRepository->getByWhere([
            'language_id' => ['=', session('currentLanguage')],
            'canonical' => ['=', $canonical],
        ]);

        if (!is_null($router) && count($router) > 0) {
            $method = 'index';
            echo app($router->controllers)->{$method}($router->module_id);
        }
    }
}
