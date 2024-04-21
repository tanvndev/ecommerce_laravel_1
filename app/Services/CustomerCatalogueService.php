<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\CustomerCatalogueServiceInterface;
use App\Repositories\Interfaces\CustomerCatalogueRepositoryInterface as CustomerCatalogueRepository;
use App\Repositories\Interfaces\CustomerRepositoryInterface as CustomerRepository;

use Illuminate\Support\Facades\DB;

class CustomerCatalogueService extends BaseService implements CustomerCatalogueServiceInterface
{
    protected $customerCatalogueRepository;
    protected $customerRepository;
    public function __construct(
        CustomerCatalogueRepository $customerCatalogueRepository,
        CustomerRepository $customerRepository
    ) {
        $this->customerCatalogueRepository = $customerCatalogueRepository;
        $this->customerRepository = $customerRepository;
    }
    function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['keyword'] = addslashes(request('keyword'));
        $condition['publish'] = request('publish');

        $customerCatalogues = $this->customerCatalogueRepository->pagination(
            ['id', 'name', 'publish', 'description'],
            $condition,
            request('perpage'),
            [],
            [],
            ['customers']

        );

        return $customerCatalogues;
    }

    function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');
            $create =  $this->customerCatalogueRepository->create($payload);

            if (!$create) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');
            $update =  $this->customerCatalogueRepository->update($id, $payload);

            if (!$update) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm
            $delete =  $this->customerCatalogueRepository->delete($id);

            if (!$delete) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
