<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\MenuServiceInterface;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuService extends BaseService implements MenuServiceInterface
{
    protected $menuRepository;
    protected $menuCatalogueRepository;

    public function __construct(
        MenuRepository $menuRepository,
        MenuCatalogueRepository $menuCatalogueRepository,
    ) {
        parent::__construct();
        $this->menuRepository = $menuRepository;
        $this->menuCatalogueRepository = $menuCatalogueRepository;
        $this->controllerName = 'MenuController';
    }


    public function save()
    {
        DB::beginTransaction();
        try {
            $payload = request()->only('menu', 'menu_catalogue_id');
            // Create menu
            $menuArr = [];
            if (count($payload['menu']['name']) > 0) {
                foreach ($payload['menu']['name'] as $key => $value) {
                    $menuId = $payload['menu']['id'][$key];
                    $menuArr = [
                        'menu_catalogue_id' => $payload['menu_catalogue_id'],
                        'order' => $payload['menu']['order'][$key],
                        'user_id' => Auth::id(),
                    ];

                    if (($menuId == 0)) {
                        $menuSave =  $this->menuRepository->create($menuArr);
                    } else {
                        // Trường hợp này sẽ update các danh mục con sau khi thay đổi menu_catalogue_id sẽ chuyển hết các danh mục con sang cho menu_catalogue_id tương ứng
                        $menuSave = $this->menuRepository->save($menuId, $menuArr);
                        // dd($menuId);
                        // dd($menuSave);
                        // Xoá đi các menuCha đã bị xoá trên giao diện
                        $this->menuRepository->forceDeleteByWhere([
                            'menu_catalogue_id' => ['=', $payload['menu_catalogue_id']],
                            'parent_id' => ['=', 0],
                            'id' => ['!=', $menuSave->id],
                        ]);


                        if ($menuSave->right - $menuSave->left > 1) {
                            $this->menuRepository->updateByWhere([
                                'left' => ['>', $menuSave->left],
                                'right' => ['<', $menuSave->right],
                            ], ['menu_catalogue_id' => $payload['menu_catalogue_id']]);
                        }
                    }
                    $this->detachAndCretePivot($menuSave, $payload, $key, $value);
                }
                $this->initNetedset();
                $this->calculateNestedSet();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    public function saveChildrend($menu)
    {
        DB::beginTransaction();
        try {
            $payload = request()->only('menu');

            // Create menu
            $menuArr = [];
            if (count($payload['menu']['name']) > 0) {
                foreach ($payload['menu']['name'] as $key => $value) {
                    $menuId = $payload['menu']['id'][$key];
                    $menuArr = [
                        'menu_catalogue_id' => $menu->menu_catalogue_id,
                        'parent_id' => $menu->id,
                        'order' => $payload['menu']['order'][$key],
                        'user_id' => Auth::id(),
                    ];

                    $menuSave = ($menuId == 0) ? $this->menuRepository->create($menuArr) : $this->menuRepository->save($menuId, $menuArr);

                    $this->detachAndCretePivot($menuSave, $payload, $key, $value);
                }
                // Dùng để tính toán lại các giá trị left right
                $this->initNetedset();
                $this->calculateNestedSet();
            }


            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function detachAndCretePivot($menuSave, $payload, $key, $value)
    {
        if ($menuSave->id > 0) {
            $menuSave->languages()->detach([session('currentLanguage')], $menuSave->id);
            $payloadLanguage = [
                'name' => $value,
                'canonical' => Str::slug($payload['menu']['canonical'][$key]),
                'language_id' => session('currentLanguage'),
            ];

            // Create pivot
            $this->menuRepository->createPivot($menuSave, $payloadLanguage, 'languages');
        }
    }

    public function dragUpdate($json = [], $menuCatalogueId = 0, $parentId = 0)
    {
        DB::beginTransaction();
        try {

            foreach ($json as $key => $value) {
                $update = [
                    'order' => count($json) - $key,
                    'parent_id' => $parentId,

                ];
                $menu = $this->menuRepository->update($value['id'], $update);
                if (isset($value['children']) && count($value['children']) > 0) {
                    $this->dragUpdate($value['children'], $menuCatalogueId, $value['id']);
                }
            }
            $this->initNetedset();
            $this->calculateNestedSet();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $this->menuRepository->forceDeleteByWhere([
                'menu_catalogue_id' => ['=', $id],
            ]);

            $this->menuCatalogueRepository->forceDelete($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function getAndConvertMenu($menu)
    {
        $menuList = $this->menuRepository->findByWhere([
            'parent_id' => ['=', $menu->id],

        ], ['*'], [
            [
                'languages' => function ($query) {
                    $query->where('language_id', session('currentLanguage'));
                }
            ]
        ], true);

        return $this->convertMenu($menuList);
    }


    public function convertMenu($menuList)
    {
        $temp = [];
        $fields = ['name', 'canonical', 'order', 'id'];

        foreach ($menuList as $key => $value) {
            foreach ($fields as $field) {
                if ($field == 'name' || $field == 'canonical') {
                    $temp[$field][] = $value->languages->first()->pivot->{$field};
                } else {
                    $temp[$field][] = $value->{$field};
                }
            }
        }

        return $temp;
    }

    public function findMenuItemTranslate($menus, $languageId)
    {
        $output = [];
        if (count($menus) > 0) {
            foreach ($menus as $key => $menu) {
                $canonical = $menu->languages->first()->pivot->canonical;
                $detailMenu = $this->menuRepository->findByWhere(
                    [
                        'id' => ['=', $menu->id]
                    ],
                    ['*'],
                    [
                        [
                            'languages' => function ($query) use ($languageId) {
                                $query->where('language_id', $languageId);
                            }
                        ]
                    ]
                );
                if (!empty($detailMenu) > 0) {
                    if ($detailMenu->languages->isNotEmpty()) {
                        $menu->translate_name = $detailMenu->languages->first()->pivot->name;
                        $menu->translate_canonical = $detailMenu->languages->first()->pivot->canonical;
                    } else {
                        $router =  $this->routerRepository->findByWhere([
                            'canonical' => ['=', $canonical],
                        ]);
                        if ($router) {
                            $controllerName = class_basename($router->controllers);
                            $modelName = str_replace('Controller', '', $controllerName);

                            $repositoryInstance = $this->getRepositoryInstance($modelName);
                            $alias = Str::snake($modelName) . '_language';
                            $object = $repositoryInstance->findByWhereHas([
                                'canonical' => $canonical,
                                'language_id' => session('currentLanguage')
                            ], ['*'], 'languages', $alias);

                            if ($object) {
                                $translateObject = $object->languages()
                                    ->where('language_id', $languageId)
                                    ->first([$alias . '.name', $alias . '.canonical']);
                                if (!is_null($translateObject)) {
                                    $menu->translate_name = $translateObject->name;
                                    $menu->translate_canonical = $translateObject->canonical;
                                }
                            }
                        }
                    }
                }

                $output[] = $menu;
            }
        }
        return $output;
    }

    public function saveTranslate($languageId = 0)
    {
        DB::beginTransaction();
        try {
            $payload = request()->only('translate');
            if (count($payload['translate']['name']) > 0) {
                foreach ($payload['translate']['name'] as $key => $value) {
                    if (is_null($value)) continue;
                    $update = [
                        'name' => $value,
                        'canonical' => Str::slug($payload['translate']['canonical'][$key]),
                        'language_id' => $languageId
                    ];
                    $menu =  $this->menuRepository->findById($payload['translate']['id'][$key]);
                    $menu->languages()->detach($languageId);
                    $this->menuRepository->createPivot($menu, $update, 'languages');
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }


    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'menus',
            'isMenu' => true,
            'foreignkey' => 'menu_id',
            'language_id' => session('currentLanguage')
        ]);
    }
}
