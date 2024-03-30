<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\GalleryCatalogueServiceInterface;
use App\Repositories\Interfaces\GalleryCatalogueRepositoryInterface as GalleryCatalogueRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GalleryCatalogueService extends BaseService implements GalleryCatalogueServiceInterface
{
    protected $galleryCatalogueRepository;
    public function __construct(
        GalleryCatalogueRepository $galleryCatalogueRepository,
    ) {
        parent::__construct();
        $this->galleryCatalogueRepository = $galleryCatalogueRepository;
        $this->controllerName = 'GalleryCatalogueController';
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
            'gallery_catalogues.id',
            'gallery_catalogues.publish',
            'gallery_catalogues.image',
            'gallery_catalogues.level',
            'gallery_catalogues.user_id',
            'gallery_catalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'gallery_catalogue_language as tb2' => ['tb2.gallery_catalogue_id', '=', 'gallery_catalogues.id']
        ];
        $orderBy = [
            'gallery_catalogues.left' => 'asc',
            'gallery_catalogues.created_at' => 'desc'
        ];

        //////////////////////////////////////////////////////////
        $galleryCatalogues = $this->galleryCatalogueRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
        );
        // dd($galleryCatalogues);

        return $galleryCatalogues;
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

            // Create galleryCatalogue
            $galleryCatalogue = $this->galleryCatalogueRepository->create($payload);

            if ($galleryCatalogue->id > 0) {

                // Format payload language
                $payloadLanguage = $this->formatPayloadLanguage($galleryCatalogue->id);

                // Tạo ra pivot vào bảng galleryCatalogue_language
                $this->createPivotLanguage($galleryCatalogue, $payloadLanguage);

                // create router
                $this->createRouter($galleryCatalogue);

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
            // Lấy ra dữ liệu của galleryCatalogue hiện tại để xoá;
            $galleryCatalogue = $this->galleryCatalogueRepository->findById($id);
            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatAlbum($payload);

            // Update galleryCatalogue
            $updateGalleryCatalogue = $this->galleryCatalogueRepository->update($id, $payload);

            if ($updateGalleryCatalogue) {
                // Lây ra payload language và format lai
                $payloadLanguage = $this->formatPayloadLanguage($galleryCatalogue->id);

                // Xoá bản ghi cũa một pivot
                $galleryCatalogue->languages()->detach([$payloadLanguage['language_id'], $id]);

                // Tạo ra pivot vào bảng {privotTable}
                $this->createPivotLanguage($galleryCatalogue, $payloadLanguage);

                // update router
                $this->updateRouter($galleryCatalogue);

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

    private function formatPayloadLanguage($galleryCatalogueId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
        // Lấy ra gallery_catalogue_id
        $payloadLanguage['gallery_catalogue_id'] = $galleryCatalogueId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }



    private function createPivotLanguage($galleryCatalogue, $payloadLanguage)
    {
        $this->galleryCatalogueRepository->createPivot($galleryCatalogue, $payloadLanguage, 'languages');
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
            $delete = $this->galleryCatalogueRepository->delete($id);

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

    private function initNetedset()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'gallery_catalogues',
            'foreignkey' => 'gallery_catalogue_id',
            'language_id' => session('currentLanguage')
        ]);
    }

    function updateStatus()
    {
        DB::beginTransaction();
        try {
            $payload[request('field')] = request('value') == 1 ? 0 : 1;
            $update =  $this->galleryCatalogueRepository->update(request('modelId'), $payload);

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
            $update =  $this->galleryCatalogueRepository->updateByWhereIn('id', request('id'), $payload);

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
