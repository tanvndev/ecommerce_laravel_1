<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\WidgetServiceInterface;
use App\Repositories\Interfaces\WidgetRepositoryInterface as WidgetRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WidgetService extends BaseService implements WidgetServiceInterface
{
    protected $widgetRepository;

    public function __construct(
        WidgetRepository $widgetRepository,
    ) {
        parent::__construct();
        $this->widgetRepository = $widgetRepository;
        $this->controllerName = 'WidgetController';
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
            'model',
            'publish'
        ];

        //////////////////////////////////////////////////////////
        $widgets = $this->widgetRepository->pagination(
            $select,
            $condition,
            request('perpage'),
        );

        // dd($widgets);
        return $widgets;
    }

    private function whereRaw()
    {
        $rawConditions = [];
        $widget_catalogue_id = request('widget_catalogue_id');
        if ($widget_catalogue_id > 0) {
            $rawConditions['whereRaw'] = [
                [
                    'tb3.widget_catalogue_id IN (
                        SELECT id 
                        FROM widget_catalogues
                        INNER JOIN widget_catalogue_language as pcl ON pcl.widget_catalogue_id = widget_catalogues.id 
                        WHERE `left` >= (SELECT `left` FROM widget_catalogues as pc WHERE pc.id = ?)
                        AND `right` <= (SELECT `right` FROM widget_catalogues as pc WHERE pc.id = ?)
                        AND pcl.language_id = ?
                    )',
                    [$widget_catalogue_id, $widget_catalogue_id, session('currentLanguage')]
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

            // Create widget
            $widget = $this->widgetRepository->create($payload);
            if ($widget->id > 0) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($widget->id);
                // Create pivot and sync
                $this->createPivotAndSync($widget, $payloadLanguage);

                // create router
                $this->createRouter($widget);
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
            // Lấy ra dữ liệu của widget hiện tại để xoá;
            $widget = $this->widgetRepository->findById($id);

            // Lấy ra payload và format lai
            $payload = request()->only($this->payload());
            $payload = $this->formatJson($payload, 'album');
            // Update widget
            $updateWidget = $this->widgetRepository->update($id, $payload);

            if ($updateWidget) {
                // Format lai payload language
                $payloadLanguage = $this->formatPayloadLanguage($id);
                // Xoá bản ghi cũa một pivot
                $widget->languages()->detach([$payloadLanguage['language_id'], $id]);
                // Create pivot and sync
                $this->createPivotAndSync($widget, $payloadLanguage);

                // update router
                $this->updateRouter($widget);
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
                [request('widget_catalogue_id')],
            ));
        }
        return [request('widget_catalogue_id')];
    }


    private function formatPayloadLanguage($widgetId)
    {
        $payloadLanguage = request()->only($this->payloadLanguage());
        //Đinh dạng slug
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

        // Lấy ra widget_id 
        $payloadLanguage['widget_id'] = $widgetId;
        // Lấy ra language_id mặc định
        $payloadLanguage['language_id'] = session('currentLanguage');
        return $payloadLanguage;
    }

    private function createPivotAndSync($widget, $payloadLanguage)
    {
        // Tạo ra pivot vào bảng widget_language
        $this->widgetRepository->createPivot($widget, $payloadLanguage, 'languages');

        // Lấy ra id catalogue
        $catalogue = $this->catalogue();
        // Đồng bộ hoá id catalogue với bảng widget_catalogue_widget
        $widget->widget_catalogues()->sync($catalogue);
    }



    function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm hay xoá cứng chỉnh trong model
            $delete = $this->widgetRepository->delete($id);

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
        return ['widget_catalogue_id', 'image', 'follow', 'publish', 'album'];
    }

    private function payloadLanguage()
    {
        return ['name', 'canonical', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    }
}
