<?php

namespace App\Http\Controllers\Servers;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Menu\{
    StoreMenuChildrenRequest,
    StoreMenuRequest,
    UpdateMenuRequest
};

use App\Services\Interfaces\MenuServiceInterface as MenuService;
use App\Services\Interfaces\MenuCatalogueServiceInterface as MenuCatalogueService;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;


class MenuController extends Controller
{
    protected $menuService;
    protected $menuCatalogueService;
    protected $menuRepository;
    protected $menuCatalogueRepository;
    protected $languageRepository;

    // Sử dụng dependency injection chuyển đổi đối tượng của một lớp được đăng ký trong container
    public function __construct(
        MenuService $menuService,
        MenuCatalogueService $menuCatalogueService,
        MenuRepository $menuRepository,
        MenuCatalogueRepository $menuCatalogueRepository,
        LanguageRepository $languageRepository,
    ) {
        parent::__construct();
        // Khởi tạo new Nestedsetbie
        $this->middleware(function ($request, $next) {
            $this->initNetedset();
            return $next($request);
        });

        $this->menuService = $menuService;
        $this->menuCatalogueService = $menuCatalogueService;
        $this->menuRepository = $menuRepository;
        $this->menuCatalogueRepository = $menuCatalogueRepository;
        $this->languageRepository = $languageRepository;
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'menus',
            'foreignkey' => 'menu_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    //
    function index()
    {
        $this->authorize('modules', 'menu.index');

        $menuCatalogues = $this->menuCatalogueService->paginate();


        $config['seo'] = __('messages.menu')['index'];

        return view('servers.menus.index', compact([
            'menuCatalogues',
            'config',
        ]));
    }

    public function create()
    {
        $this->authorize('modules', 'menu.create');

        $config['seo'] = __('messages.menu')['create'];
        $config['method'] = 'create';

        $menuCatalogues = $this->menuCatalogueRepository->all();

        return view('servers.menus.store', compact([
            'config',
            'menuCatalogues',
        ]));
    }

    public function store(StoreMenuRequest $request)
    {

        $successMessage = $this->getToastMessage('menu', 'success', 'create');
        $errorMessage = $this->getToastMessage('menu', 'error', 'create');

        if ($this->menuService->save()) {
            return redirect()->route('menu.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('menu.create')->with('toast_error', $errorMessage);
    }

    public function edit($id)
    {
        // dd($this->currentLanguage);
        $this->authorize('modules', 'menu.edit');
        $conditons = [
            'menu_catalogue_id' => ['=', $id],
        ];
        $menus = $this->menuRepository->findByWhere(
            $conditons,
            ['*'],
            [
                [
                    'languages' => function ($query) {
                        $query->where('language_id', $this->currentLanguage);
                    }
                ]
            ],
            true,
            ['order' => 'desc']
        );

        $menuCatalogue = $this->menuCatalogueRepository->findById($id);

        $config['seo'] = __('messages.menu')['show'];

        return view('servers.menus.show', compact([
            'config',
            'menus',
            'menuCatalogue',
        ]));
    }

    public function editMenu($id)
    {
        $this->authorize('modules', 'menu.edit');
        $conditons = [
            'menu_catalogue_id' => ['=', $id],
            'parent_id' => ['=', 0],
        ];
        $menus = $this->menuRepository->findByWhere(
            $conditons,
            ['*'],
            [
                [
                    'languages' => function ($query) {
                        $query->where('language_id', $this->currentLanguage);
                    }
                ]
            ],
            true,
            ['order' => 'desc']
        );
        $menuList = $this->menuService->convertMenu($menus);
        $menuCatalogues = $this->menuCatalogueRepository->all();
        $config['seo'] = __('messages.menu')['update'];
        $config['method'] = 'update';

        return view('servers.menus.store', compact([
            'config',
            'menuList',
            'menuCatalogues',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('menu', 'success', 'update');
        $errorMessage = $this->getToastMessage('menu', 'error', 'update');

        if ($this->menuService->save()) {
            return redirect()->route('menu.edit', $id)->with('toast_success', $successMessage);
        }
        return back()->with('toast_error', $errorMessage);
    }

    public function children($id)
    {
        $this->authorize('modules', 'menu.create');

        $config['seo'] = __('messages.menu')['children'];
        $config['method'] = 'children';
        $menu = $this->menuRepository->findById($id, ['*'], [
            'languages' => function ($query) {
                $query->where('language_id', $this->currentLanguage);
            }
        ]);

        $menuList = $this->menuService->getAndConvertMenu($menu);
        // dd($menuList);

        return view('servers.menus.children', compact([
            'config',
            'menu',
            'menuList'
        ]));
    }

    public function saveChildren(StoreMenuChildrenRequest $request, $id)
    {
        $successMessage = $this->getToastMessage('menu', 'success', 'children');
        $errorMessage = $this->getToastMessage('menu', 'error', 'children');

        $menu = $this->menuRepository->findById($id);
        if ($this->menuService->saveChildrend($menu)) {
            return redirect()->route('menu.edit', $menu->menu_catalogue_id)->with('toast_success', $successMessage);
        }
        return redirect()->route('menu.save.children', $id)->with('toast_error', $errorMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->authorize('modules', 'menu.destroy');

        $successMessage = $this->getToastMessage('menu', 'success', 'delete');
        $errorMessage = $this->getToastMessage('menu', 'error', 'delete');

        if ($request->_id == null) {
            return redirect()->route('menu.index')->with('toast_error', $errorMessage);
        }
        if ($this->menuService->destroy($request->_id)) {
            return redirect()->route('menu.index')->with('toast_success', $successMessage);
        }
        return redirect()->route('menu.index')->with('toast_error', $errorMessage);
    }

    public function translate($id, $languageId)
    {
        $config['seo'] = __('messages.menu')['translate'];
        $config['method'] = 'translate';
        $language = $this->languageRepository->findById($languageId, ['id', 'name', 'canonical']);
        $menuCatalogue = $this->menuCatalogueRepository->findById($id);

        $menus = $this->menuRepository->findByWhere(
            [
                'menu_catalogue_id' => ['=', $id]
            ],
            ['*'],
            [
                [
                    'languages' => function ($query) {
                        $query->where('language_id', $this->currentLanguage);
                    }
                ]
            ],
            true,
            ['left' => 'asc']
        );
        $menus = buildMenu($this->menuService->findMenuItemTranslate($menus, $languageId));
        // dd($menus);

        // $menuList = $this->menuService->getAndConvertMenu($menu);
        // dd($menuList);

        return view('servers.menus.translate', compact([
            'config',
            'menus',
            'menuCatalogue',
        ]));
    }

    public function saveTranslate($languageId)
    {
        $successMessage = $this->getToastMessage('menu', 'success', 'translate');
        $errorMessage = $this->getToastMessage('menu', 'error', 'translate');

        if ($this->menuService->saveTranslate($languageId)) {
            return redirect()->back()->with('toast_success', $successMessage);
        }
        return redirect()->back()->with('toast_error', $errorMessage);
    }
}
