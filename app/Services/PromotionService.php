<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\PromotionServiceInterface;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PromotionService extends BaseService implements PromotionServiceInterface
{
    protected $promotionRepository;

    public function __construct(
        PromotionRepository $promotionRepository,
    ) {
        parent::__construct();
        $this->promotionRepository = $promotionRepository;
        $this->controllerName = 'PromotionController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
        ];

        $select = [
            'promotions.id',
            'promotions.publish',
            'promotions.image',
            'promotions.user_id',
            'promotions.order',
            'tb2.name',
            'tb2.canonical',
        ];

        //////////////////////////////////////////////////////////
        $promotions = $this->promotionRepository->pagination(
            $select,
            $condition,
            request('perpage'),
        );

        // dd($promotions);
        return $promotions;
    }


    function create()
    {

        DB::beginTransaction();
        try {



            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }


    function update($id)
    {

        DB::beginTransaction();
        try {


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
            $delete = $this->promotionRepository->delete($id);

            // Xoa router
            $this->deleteRouter($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
