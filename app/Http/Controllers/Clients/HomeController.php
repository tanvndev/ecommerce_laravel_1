<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $slideRepository;
    public function __construct()
    {
        parent::__construct();
        $this->slideRepository = app(SlideRepository::class);
    }
    public function index()
    {
        $slides = $this->slideRepository->findByWhere(
            [
                'publish' => ['=', config('apps.general.defaultPublish')],
                'keyword' => ['=', 'main-slide']
            ]
        );
        $slideItems = $slides->item[session('currentLanguage')];
        // dd($slideItems);
        return view('clients.home.index', compact([
            'slides',
            'slideItems'

        ]));
    }
}
