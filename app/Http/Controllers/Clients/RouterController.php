<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;


class RouterController extends Controller
{
    protected $routerRepository;

    public function __construct()
    {
        parent::__construct();
        $this->routerRepository = app(RouterRepository::class);
    }
    public function index($canonical = '')
    {

        $router = $this->routerRepository->findByWhere([
            'language_id' => ['=', $this->currentLanguage],
            'canonical' => ['=', $canonical],
        ]);

        if (!is_null($router) && !empty($router)) {
            $method = 'index';
            echo app($router->controllers)->{$method}($router->module_id);
        }
    }
}
