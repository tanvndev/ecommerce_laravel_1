<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\AttributeServiceInterface;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeService extends BaseService implements AttributeServiceInterface
{
    protected $attributeRepository;

    public function __construct(
        AttributeRepository $attributeRepository,
    ) {
        parent::__construct();
        $this->attributeRepository = $attributeRepository;
        $this->controllerName = 'AttributeController';
    }
    function paginate()
    {

        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
            'attribute_catalogue_id' => request('attribute_catalogue_id'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];

        $select = [
            'attributes.id',
            'attributes.publish',
            'attributes.image',
            'attributes.user_id',
            'attributes.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'attribute_language as tb2' => ['tb2.attribute_id', '=', 'attributes.id'],
            'attribute_catalogue_attribute as tb3' => ['tb3.attribute_id', '=', 'attributes.id'],
        ];
        $orderBy = [];

        //////////////////////////////////////////////////////////
        $attributes = $this->attributeRepository->pagination(
            $select,
            $condition,
            request('perpage', 20),
            $orderBy,
            $join,
            ['attribute_catalogues'],
            $select,
            $this->whereRaw()

        );

        // dd($attributes);
        return $attributes;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        $attribute_catalogue_id = request('attribute_catalogue_id');
        if ($attribute_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.attribute_catalogue_id IN (
                        SELECT id 
                        FROM attribute_catalogues
                        INNER JOIN attribute_catalogue_language as pcl ON pcl.attribute_catalogue_id = attribute_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM attribute_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM attribute_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [$attribute_catalogue_id, $attribute_catalogue_id, session('currentLanguage')]
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
            $payload = $this->formatJson($payload, 'album');
            // Lấy ra id người dùng hiện tại
            $payload['user_id'] = Auth::id();

            // Create attribute
            $attribute = $this->attributeRepository->create($payload);
            if ($attribute->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($attribute->id);
                // Create pivot and sync
                $this->createPivotAndSync($attribute, $payloadLanguage);

                // create router
                $this->createRouter($attribute);
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
            // Lấy ra dữ liệu của attribute hiện tại để xoá;
            $attribute = $this->attributeRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Update attribute
            $updateAttribute = $this->attributeRepository->update($id, $payload);

            if ($updateAttribute) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $attribute->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($attribute, $payloadLanguage);

                // update router
                $this->updateRouter($attribute);
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
        if (!empty(request('catalogue'))) {
            return array_unique(array_merge(
                request('catalogue'),
                [request('attribute_catalogue_id')],
            ));
        }
        return [request('attribute_catalogue_id')];
    }


    private function formatPayloadLanguage($attributeId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra attribute_id 
        $payloadLanguage['attribute_id'] = $attributeId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync($attribute, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng attribute_language
        $this->attributeRepository->createPivot($attribute, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng attribute_catalogue_attribute
        $attribute->attribute_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->attributeRepository->delete($id);

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

    private function payload()
    {
        return ['attribute_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
