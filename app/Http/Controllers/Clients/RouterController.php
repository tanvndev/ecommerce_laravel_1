<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;


class RouterController extends Controller
{
    protected $routerRepository;

    public function __construct(
        RouterRepository $routerRepository
    ) {
        parent::__construct();
        $this->routerRepository = $routerRepository;
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
