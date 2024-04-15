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
        $this->controllerName = 'PostCatalogueController';
    }


    public function paginate()
    {
        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];
        // dd($condition);

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
            $payload = $this->formatJson($payload, 'album');
            // Lấy ra id của người dùng hiện tại.
            $payload['user_id'] = Auth::id();

            // Create post catalogue
            $postCatalogue = $this->postCatalogueRepository->create($payload);

            if ($postCatalogue->id > 0) {

                // Format payload language
                $payloadLanguage = $this->formatPayloadLanguage($postCatalogue->id);

                // Tạo ra pivot vào bảng post_catalogue_language
                $this->createPivotLanguage($postCatalogue, $payloadLanguage);

                // create router
                $this->createRouter($postCatalogue);

                // Dùng để tính toán lại các giá trị left right
                $this->initNetedset();
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
            $payload = $this->formatJson($payload, 'album');

            // Update postCatalogue
            $updatePostCatalogue = $this->postCatalogueRepository->update($id, $payload);

            if ($updatePostCatalogue) {
                // Lây ra payload language và format lai
                $payloadLanguage = $this->formatPayloadLanguage($postCatalogue->id);

                // Xoá bản ghi cũa một pivot
                $postCatalogue->languages()->detach([$payloadLanguage['language_id'], $id]);

                // Tạo ra pivot vào bảng post_catalogue_language
                $this->createPivotLanguage($postCatalogue, $payloadLanguage);

                // update router
                $this->updateRouter($postCatalogue);

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

    private function formatPayloadLanguage($postCatalogueId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
        // Lấy ra post_catalogue_id
        $payloadLanguage['post_catalogue_id'] = $postCatalogueId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }



    private function createPivotLanguage($postCatalogue, $payloadLanguage)
    {
        $this->postCatalogueRepository->createPivot($postCatalogue, $payloadLanguage, 'languages');
    }

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => session('currentLanguage')
        ]);
    }


    private function payload()
    {
        return ['parent_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }

    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->postCatalogueRepository->delete($id);

            // Xoa router
            $this->deleteRouter($id);

            // Dùng để tính toán lại các giá trị left right
            $this->initNetedset();
            $this->calculateNestedSet();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
