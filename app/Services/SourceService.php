<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\SourceServiceInterface;
use App\Repositories\Interfaces\SourceRepositoryInterface as SourceRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SourceService extends BaseService implements SourceServiceInterface
{
    protected $sourceRepository;

    public function __construct(
        SourceRepository $sourceRepository,
    ) {
        parent::__construct();
        $this->sourceRepository = $sourceRepository;
        $this->controllerName = 'SourceController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
        ];

        $select = [
            'id',
            'name',
            'keyword',
            'publish',
            'description'
        ];

        //////////////////////////////////////////////////////////
        $sources = $this->sourceRepository->pagination(
            $select,
            $condition,
            request('perpage'),
        );

        // dd($sources);
        return $sources;
    }


    public function create()
    {

        DB::beginTransaction();
        try {
            $payload = request()->only('name', 'keyword', 'description');
            $payload['keyword'] = Str::slug($payload['keyword']);

            $this->sourceRepository->create($payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }


    public function update($id)
    {

        DB::beginTransaction();
        try {
            $payload = request()->only('name', 'keyword', 'description');
            $payload['keyword'] = Str::slug($payload['keyword']);

            $this->sourceRepository->update($id, $payload);


            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->sourceRepository->delete($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
