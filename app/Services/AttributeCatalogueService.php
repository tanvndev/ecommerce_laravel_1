<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\AttributeCatalogueServiceInterface;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeCatalogueService extends BaseService implements AttributeCatalogueServiceInterface
{
    protected $attributeCatalogueRepository;

    public function __construct(
        AttributeCatalogueRepository $attributeCatalogueRepository,
    ) {
        parent::__construct();
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
        $this->controllerName = 'AttributeCatalogueController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'attributeCatalogue_catalogue_id' => request('attributeCatalogue_catalogue_id'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];

        $select = [
            'attributeCatalogues.id',
            'attributeCatalogues.publish',
            'attributeCatalogues.image',
            'attributeCatalogues.user_id',
            'attributeCatalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'attributeCatalogue_language as tb2' => ['tb2.attributeCatalogue_id', '=', 'attributeCatalogues.id'],
            'attributeCatalogue_catalogue_attributeCatalogue as tb3' => ['tb3.attributeCatalogue_id', '=', 'attributeCatalogues.id'],
        ];
        $orderBy = [];

        //////////////////////////////////////////////////////////
        $attributeCatalogues = $this->attributeCatalogueRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
            ['attributeCatalogue_catalogues'],
            $select,
            $this->whereRaw()

        );

        // dd($attributeCatalogues);
        return $attributeCatalogues;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        $attributeCatalogue_catalogue_id = request('attributeCatalogue_catalogue_id');
        if ($attributeCatalogue_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.attributeCatalogue_catalogue_id IN (
                        SELECT id 
                        FROM attributeCatalogue_catalogues
                        INNER JOIN attributeCatalogue_catalogue_language as pcl ON pcl.attributeCatalogue_catalogue_id = attributeCatalogue_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM attributeCatalogue_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM attributeCatalogue_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [$attributeCatalogue_catalogue_id, $attributeCatalogue_catalogue_id, session('currentLanguage')]
                ]
            ];
        }
        return $rawConditions;
    }

    function create()
    {

        DB::beginTransaction();
        try {

            //   Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatAlbum($payload);
            // Lấy ra id người dùng hiện tại
            $payload['user_id'] = Auth::id();

            // Create attributeCatalogue
            $attributeCatalogue = $this->attributeCatalogueRepository->create($payload);
            if ($attributeCatalogue->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($attributeCatalogue->id);
                // Create pivot and sync
                $this->createPivotAndSync($attributeCatalogue, $payloadLanguage);

                // create router
                $this->createRouter($attributeCatalogue);
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


    function update($id)
    {

        DB::beginTransaction();
        try {
            // Lấy ra dữ liệu của attributeCatalogue hiện tại để xoá;
            $attributeCatalogue = $this->attributeCatalogueRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatAlbum($payload);
            // Update attributeCatalogue
            $updateAttributeCatalogue = $this->attributeCatalogueRepository->update($id, $payload);

            if ($updateAttributeCatalogue) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $attributeCatalogue->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($attributeCatalogue, $payloadLanguage);

                // update router
                $this->updateRouter($attributeCatalogue);
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

    private function catalogue()
    {
        return array_unique(array_merge(
            request('catalogue'),
            [request('attributeCatalogue_catalogue_id')],
        ));
    }


    private function formatPayloadLanguage($attributeCatalogueId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra attributeCatalogue_id 
        $payloadLanguage['attributeCatalogue_id'] = $attributeCatalogueId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync($attributeCatalogue, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng attributeCatalogue_language
        $this->attributeCatalogueRepository->createPivot($attributeCatalogue, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng attributeCatalogue_catalogue_attributeCatalogue
        $attributeCatalogue->attributeCatalogue_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->attributeCatalogueRepository->delete($id);

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
            $update =  $this->attributeCatalogueRepository->update(request('modelId'), $payload);

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
            $update =  $this->attributeCatalogueRepository->updateByWhereIn('id', request('id'), $payload);

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
        return ['attributeCatalogue_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
