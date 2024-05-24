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
        $menuCatalogue = $this->menuCatalogueRepository->findByWhere(
            [
                'publish' => ['=', config('apps.general.defaultPublish')],
            ],
            ['id', 'keyword'],
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
            true,
        );

        $menus = [];
        $htmlType = ['main-menu'];
        if ($menuCatalogue != null) {
            foreach ($menuCatalogue as $key => $value) {
                $type = (in_array($value->keyword, $htmlType)) ? 'html' : 'array';
                $menus[$value->keyword] = client_recursive_menu(recursive($value->menus), 0, $type);
            }
        }
        // dd($menus);

        $view->with('menus', $menus);
    }
}
