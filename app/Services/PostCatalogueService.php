<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PostCatalogueService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    public function __construct(PostCatalogueRepository $postCatalogueRepository)
    {
        $this->postCatalogueRepository = $postCatalogueRepository;
    }
    function paginate()
    {

        $condition['keyword'] = addslashes(request('keyword'));
        $condition['publish'] = request('publish');

        $postCatalogues = $this->postCatalogueRepository->pagination(
            ['id', 'name', 'image', 'publish', 'canonical', 'user_id'],
            $condition,
            [],
            request('perpage'),
            ['users']
        );

        // dd($postCatalogues);

        return $postCatalogues;
    }

    function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->only($this->payload());
            // Lấy ra id của người dùng hiện tại.
            $payload['user_id'] = Auth::id();
            dd($payload);
            $createPostCatalogue = $this->postCatalogueRepository->create($payload);

            if ($createPostCatalogue->id > 0) {
                $payloadPostCatalogueLanguage = request()->only($this->payloadPostCatalogueLanguage());
            }

            if (!$createPostCatalogue) {
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
            $update =  $this->postCatalogueRepository->update($id, $payload);

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
            $delete =  $this->postCatalogueRepository->delete($id);

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

    function updateStatus()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value') == 1 ? 0 : 1;
            $update =  $this->postCatalogueRepository->update(request('modelId'), $payload);

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

    public function updateStatusAll()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value');
            $update =  $this->postCatalogueRepository->updateByWhereIn('id', request('id'), $payload);

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

    private function payload()
    {
        return ['parent_id', 'image', 'follow', 'publish'];
    }

    private function payloadPostCatalogueLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keywords'];
    }
}
