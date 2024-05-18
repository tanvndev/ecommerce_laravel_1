<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use App\Services\Interfaces\WidgetServiceInterface as WidgetService;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $slideRepository;
    protected $widgetService;
    public function __construct()
    {
        parent::__construct();
        $this->slideRepository = app(SlideRepository::class);
        $this->widgetService = app(WidgetService::class);
    }
    public function index()
    {
        $widgets = [
            'categories' => $this->widgetService->findWidgetByKeyword('categories', ['children' => true, 'object' => true, 'countObject' => true]),
        ];
        $slides = $this->slideRepository->findByWhere(
            [
                'publish' => ['=', config('apps.general.defaultPublish')],
                'keyword' => ['=', 'main-slide']
            ]
        );
        $slideItems = $slides->item[session('currentLanguage')];
        return view('clients.home.index', compact([
            'slides',
            'slideItems',
            'widgets'
        ]));
    }
}
