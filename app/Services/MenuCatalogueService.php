<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\MenuCatalogueServiceInterface;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuCatalogueService extends BaseService implements MenuCatalogueServiceInterface
{
    protected $menuCatalogueRepository;

    public function __construct(
        MenuCatalogueRepository $menuCatalogueRepository,
    ) {
        parent::__construct();
        $this->menuCatalogueRepository = $menuCatalogueRepository;
        $this->controllerName = 'MenuCatalogueController';
    }
    function paginate()
    {
        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
        ];

        $menuCatalogue = $this->menuCatalogueRepository->pagination(
            ['id', 'name', 'keyword', 'publish'],
            $condition,
            request('perpage'),
        );

        return $menuCatalogue;
    }



    function create()
    {

        DB::beginTransaction();
        try {
            $payload = request()->only(['name', 'keyword']);
            $payload['keyword'] = Str::slug($payload['keyword']);
            $menuCatalogue = $this->menuCatalogueRepository->create($payload);

            DB::commit();
            return [
                'id' => $menuCatalogue->id,
                'name' => $menuCatalogue->name,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }
}
