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
            'publish',
            'short_code',
            'description'
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

    public function create()
    {

        DB::beginTransaction();
        try {

            $payload = request()->only('name', 'keyword', 'album', 'short_code', 'model');
            $payload['model_id'] = request('modelItem.id');
            $payload['description'] = [
                session('currentLanguage') ?? 1 => request('description'),
            ];

            $this->widgetRepository->create($payload);

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

            $payload = request()->only('name', 'keyword', 'album', 'short_code', 'model');
            $payload['model_id'] = request('modelItem.id');

            // Lấy mô tả hiện tại của widget
            $widget = $this->widgetRepository->findById($id);
            $widgetDescription = $widget->description;

            $widgetDescription[session('currentLanguage')] = request('description');

            // Cập nhật mô tả của widget với mô tả mới
            $payload['description'] = $widgetDescription;

            $this->widgetRepository->update($id, $payload);
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

    public function saveTranslate()
    {
        DB::beginTransaction();
        try {
            $widget = $this->widgetRepository->findById(request('widgetId'));

            // Lấy ra danh sách ngôn ngữ
            $widgetDescription = $widget->description;

            // Cập nhật mô tả dịch cho ngôn ngữ cụ thể
            $widgetDescription[request('languageId')] = request('translate_description');

            // Cập nhật mô tả của widget với mô tả dịch mới
            $widget->description = $widgetDescription;
            $widget->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
