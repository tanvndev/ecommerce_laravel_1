<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use App\Services\Interfaces\SlideServiceInterface as SlideService;
use App\Services\Interfaces\WidgetServiceInterface as WidgetService;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $slideRepository;
    protected $widgetService;
    protected $slideService;
    public function __construct()
    {
        parent::__construct();
        $this->slideRepository = app(SlideRepository::class);
        $this->slideService = app(SlideService::class);
        $this->widgetService = app(WidgetService::class);
    }
    public function index()
    {
        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'categories', 'children' => true, 'object' => true, 'countObject' => true, 'promotion' => true],
            ['keyword' => 'home-outstanding-products', 'object' => true, 'promotion' => true],
            ['keyword' => 'news', 'object' => true],
            ['keyword' => 'home-arrival-product', 'object' => true, 'children' => true, 'promotion' => true],
        ]);
        // dd($widgets);

        // dd($widgets['home-arrival-product']->object);

        $slides = $this->slideService->getSlide(
            [
                ['keyword' => 'main-slide'],
                ['keyword' => 'why-choose']
            ]
        );

        return view('clients.home.index', compact([
            'slides',
            'widgets'
        ]));
    }
}
