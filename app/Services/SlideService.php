<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\SlideServiceInterface;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SlideService extends BaseService implements SlideServiceInterface
{
    protected $slideRepository;

    public function __construct(
        SlideRepository $slideRepository,
    ) {
        parent::__construct();
        $this->slideRepository = $slideRepository;
        $this->controllerName = 'SlideController';
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
            'description',

        ];

        //////////////////////////////////////////////////////////
        $slides = $this->slideRepository->pagination(
            $select,
            $condition,
            request('perpage'),
        );

        // dd($slides);
        return $slides;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        $slide_catalogue_id = request('slide_catalogue_id');
        if ($slide_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.slide_catalogue_id IN (
                        SELECT id 
                        FROM slide_catalogues
                        INNER JOIN slide_catalogue_language as pcl ON pcl.slide_catalogue_id = slide_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM slide_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM slide_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [$slide_catalogue_id, $slide_catalogue_id, session('currentLanguage')]
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

            // Create slide
            $slide = $this->slideRepository->create($payload);
            if ($slide->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($slide->id);
                // Create pivot and sync
                $this->createPivotAndSync($slide, $payloadLanguage);

                // create router
                $this->createRouter($slide);
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
            // Lấy ra dữ liệu của slide hiện tại để xoá;
            $slide = $this->slideRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Update slide
            $updateSlide = $this->slideRepository->update($id, $payload);

            if ($updateSlide) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $slide->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($slide, $payloadLanguage);

                // update router
                $this->updateRouter($slide);
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
                [request('slide_catalogue_id')],
            ));
        }
        return [request('slide_catalogue_id')];
    }


    private function formatPayloadLanguage($slideId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra slide_id 
        $payloadLanguage['slide_id'] = $slideId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync($slide, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng slide_language
        $this->slideRepository->createPivot($slide, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng slide_catalogue_slide
        $slide->slide_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->slideRepository->delete($id);

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
        return ['slide_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
