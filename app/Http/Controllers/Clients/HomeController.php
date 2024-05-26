<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use App\Services\Interfaces\SlideServiceInterface as SlideService;
use App\Services\Interfaces\WidgetServiceInterface as WidgetService;

class HomeController extends Controller
{
    protected $slideRepository;
    protected $widgetService;
    protected $slideService;
    public function __construct(
        SlideRepository $slideRepository,
        SlideService $slideService,
        WidgetService $widgetService
    ) {
        parent::__construct();
        $this->slideRepository = $slideRepository;
        $this->slideService = $slideService;
        $this->widgetService = $widgetService;
    }
    public function index()
    {
        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'categories', 'children' => true, 'object' => true, 'countObject' => true, 'promotion' => true],
            ['keyword' => 'home-outstanding-products', 'object' => true, 'promotion' => true],
            ['keyword' => 'news', 'object' => true],
            ['keyword' => 'home-arrival-product', 'object' => true, 'promotion' => true],
            ['keyword' => 'home-most-sold', 'object' => true, 'promotion' => true],
        ]);
        // dd($widgets);

        // dd($widgets['home-most-sold']->object);
        $system = $this->getSystemCustomSetting();
        $seo = [
            'meta_title' => $system['seo_meta_title'],
            'meta_description' => $system['seo_meta_description'],
            'meta_keywords' => $system['seo_meta_keyword'],
            'meta_image' => $system['seo_meta_image'],
            'canonical' => config('app.url'),
        ];
        $slides = $this->slideService->getSlide(
            [
                ['keyword' => 'main-slide'],
                ['keyword' => 'why-choose']
            ]
        );

        return view('clients.home.index', compact([
            'seo',
            'slides',
            'widgets'
        ]));
    }
}
