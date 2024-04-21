<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\SourceServiceInterface;
use App\Repositories\Interfaces\SourceRepositoryInterface as SourceRepository;
use Illuminate\Support\Facades\Auth;
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
            'source_catalogue_id' => request('source_catalogue_id'),
            'where' => [
                'tb2.language_id' => ['=', session('currentLanguage')]
            ]
        ];

        $select = [
            'sources.id',
            'sources.publish',
            'sources.image',
            'sources.user_id',
            'sources.order',
            'tb2.name',
            'tb2.canonical',
        ];
        $join = [
            'source_language as tb2' => ['tb2.source_id', '=', 'sources.id'],
            'source_catalogue_source as tb3' => ['tb3.source_id', '=', 'sources.id'],
        ];
        $orderBy = [];

        //////////////////////////////////////////////////////////
        $sources = $this->sourceRepository->pagination(
            $select,
            $condition,
            request('perpage'),
            $orderBy,
            $join,
            ['source_catalogues'],
            $select,
            $this->whereRaw()

        );

        // dd($sources);
        return $sources;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        $source_catalogue_id = request('source_catalogue_id');
        if ($source_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.source_catalogue_id IN (
                        SELECT id 
                        FROM source_catalogues
                        INNER JOIN source_catalogue_language as pcl ON pcl.source_catalogue_id = source_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM source_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM source_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [$source_catalogue_id, $source_catalogue_id, session('currentLanguage')]
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

            // Create source
            $source = $this->sourceRepository->create($payload);
            if ($source->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($source->id);
                // Create pivot and sync
                $this->createPivotAndSync($source, $payloadLanguage);

                // create router
                $this->createRouter($source);
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
            // Lấy ra dữ liệu của source hiện tại để xoá;
            $source = $this->sourceRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Update source
            $updateSource = $this->sourceRepository->update($id, $payload);

            if ($updateSource) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $source->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($source, $payloadLanguage);

                // update router
                $this->updateRouter($source);
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
                    [request('source_catalogue_id')],
                ));
            }
            return [request('source_catalogue_id')];
        }


    private function formatPayloadLanguage($sourceId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra source_id 
        $payloadLanguage['source_id'] = $sourceId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync($source, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng source_language
        $this->sourceRepository->createPivot($source, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng source_catalogue_source
        $source->source_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->sourceRepository->delete($id);

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
        return ['source_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
