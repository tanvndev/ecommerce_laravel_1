<?php

namespace App\Http\ViewComposers;

use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use Illuminate\View\View;


class MenuComposer
{
    private $menuCatalogueRepository;
    public function __construct()
    {
        $this->menuCatalogueRepository = app(MenuCatalogueRepository::class);
    }
    public function compose(View $view)
    {
        $menu = $this->menuCatalogueRepository->findByWhere(
            [
                'keyword' => ['=', 'main-menu']
            ],
            ['*'],
            [
                [
                    'menus' => function ($query) {
                        $query->with([
                            'languages' => function ($query) {
                                $query->where('language_id', session('currentLanguage'));
                            }
                        ]);
                    }
                ]
            ],
            true
        );
        dd($menu);

        $view->with('menu', $menu);
    }
}
