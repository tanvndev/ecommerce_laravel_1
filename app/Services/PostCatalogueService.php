<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
    ) {
        parent::__construct();
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->currentLanguage = $this->currentLanguage();
        $this->controllerName = 'PostCatalogueController';

        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->currentLanguage
        ]);
    }
    function paginate()
    {
        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'where' => [
                'tb2.language_id' => ['=', $this->currentLanguage]
            ]
        ];

        $select = [
            'post_catalogues.id',
            'post_catalogues.publish',
            'post_catalogues.image',
            'post_catalogues.level',
            'post_catalogues.user_id',
            'post_catalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'post_catalogue_language as tb2' => ['tb2.post_catalogue_id', '=', 'post_catalogues.id']
        ];
        $orderBy = [
            'post_catalogues.left' => 'asc',
            'post_catalogues.created_at' => 'desc'
        ];

        //////////////////////////////////////////////////////////
        $postCatalogues = $this->postCatalogueRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
        );
        // dd($postCatalogues);

        return $postCatalogues;
    }

    function create()
    {

        DB::beginTransaction();
        try {
            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatAlbum($payload);
            // Lấy ra id của người dùng hiện tại.
            $payload['user_id'] = Auth::id();

            // Create post catalogue
            $postCatalogue = $this->postCatalogueRepository->create($payload);

            if ($postCatalogue->id > 0) {

                // Format payload language
                $payloadPostCatalogueLanguage = $this->formatPayloadLanguage($postCatalogue->id);

                // Tạo ra pivot vào bảng post_catalogue_language
                $this->createPivotLanguage($postCatalogue, $payloadPostCatalogueLanguage);

                // create router
                $this->createRouter($postCatalogue);

                // Dùng để tính toán lại các giá trị left right
                $this->calculateNestedSet();
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
            // Lấy ra dữ liệu của postCatalogue hiện tại để xoá;
            $postCatalogue = $this->postCatalogueRepository->findById($id);
            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatAlbum($payload);

            // Update postCatalogue
            $updatePostCatalogue =  $this->postCatalogueRepository->update($id, $payload);

            if ($updatePostCatalogue) {
                // Lây ra payload language và format lai
                $payloadPostCatalogueLanguage = $this->formatPayloadLanguage($postCatalogue->id);

                // Xoá bản ghi cũa một pivot
                $postCatalogue->languages()->detach([$payloadPostCatalogueLanguage['language_id'], $id]);

                // Tạo ra pivot vào bảng post_catalogue_language
                $this->createPivotLanguage($postCatalogue, $payloadPostCatalogueLanguage);

                // update router
                $this->updateRouter($postCatalogue);

                // Dùng để tính toán lại các giá trị left right
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

    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->postCatalogueRepository->delete($id);

            // Dùng để tính toán lại các giá trị left right
            $this->calculateNestedSet();

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

    private function formatPayloadLanguage($postCatalogueId)
    {
        $payloadPostCatalogueLanguage = request()->only($this->payloadPostCatalogueLanguage());
        //Đinh dạng slug
        $payloadPostCatalogueLanguage['canonical'] = Str::slug($payloadPostCatalogueLanguage['canonical']);
        // Lấy ra post_catalogue_id
        $payloadPostCatalogueLanguage['post_catalogue_id'] = $postCatalogueId;
        // Lấy ra language_id mặc định
        $payloadPostCatalogueLanguage['language_id'] = $this->currentLanguage();
        return $payloadPostCatalogueLanguage;
    }



    private function createPivotLanguage($postCatalogue, $payloadPostCatalogueLanguage)
    {
        $this->postCatalogueRepository->createPivot($postCatalogue, $payloadPostCatalogueLanguage, 'languages');
    }


    private function payload()
    {
        return ['parent_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadPostCatalogueLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
