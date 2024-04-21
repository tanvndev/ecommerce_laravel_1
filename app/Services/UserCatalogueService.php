<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\UserCatalogueServiceInterface;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;

use Illuminate\Support\Facades\DB;

class UserCatalogueService extends BaseService implements UserCatalogueServiceInterface
{
    protected $userCatalogueRepository;
    protected $userRepository;
    public function __construct(
        UserCatalogueRepository $userCatalogueRepository,
        UserRepository $userRepository
    ) {
        $this->userCatalogueRepository = $userCatalogueRepository;
        $this->userRepository = $userRepository;
    }
    function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['keyword'] = addslashes(request('keyword'));
        $condition['publish'] = request('publish');

        $userCatalogues = $this->userCatalogueRepository->pagination(
            ['id', 'name', 'publish', 'description'],
            $condition,
            request('perpage'),
            [],
            [],
            ['users']

        );

        return $userCatalogues;
    }

    function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');
            $create =  $this->userCatalogueRepository->create($payload);

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
            $update =  $this->userCatalogueRepository->update($id, $payload);

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
            $delete =  $this->userCatalogueRepository->delete($id);

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


    public function setPermission()
    {
        DB::beginTransaction();
        try {
            $permissions = request('permission');
            foreach ($permissions as $key => $value) {
                $userCatalogue = $this->userCatalogueRepository->findById($key);
                $userCatalogue->permissions()->sync($value);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    // Hàm này thay đổi trạng thái của user khi thay đổi trạng thái user catalogue
    private function changeUserStatus($dataPost)
    {
        DB::beginTransaction();
        try {
            $arrayId = [];
            $value = '';

            // Là một mảng thì là Chọn tất cả còn k là ngược lại chọn 1 để update publish
            if (isset($dataPost['id'])) {
                $arrayId = $dataPost['id'];
                $value = $dataPost['value'];
            } else {
                $arrayId[] = $dataPost['modelId'];
                $value = $dataPost['value'] == 1 ? 0 : 1;
            }
            $payload[$dataPost['field']] = $value;

            $update = $this->userRepository->updateByWhereIn('user_catalogue_id', $arrayId, $payload);

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
}
