<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\SlideServiceInterface;
use App\Repositories\Interfaces\SlideRepositoryInterface as SlideRepository;
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
            'publish',
            'item'
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

    public function convertSlidesToArray($slides = null)
    {
        $fields = ['image', 'description', 'canonical', 'window', 'name', 'alt'];
        $slide = array_fill_keys($fields, []);

        foreach ($fields as $field) {
            $slide[$field] = array_column($slides, $field);
        }
        return $slide;
    }



    public function create()
    {
        DB::beginTransaction();
        try {
            //   Lấy ra payload và format lai
            $payload = request()->only('name', 'keyword', 'setting', 'short_code');
            $payload['keyword'] = Str::slug($payload['keyword']);
            $payload['item'] = $this->handleSildeItem(request('slide'));

            $this->slideRepository->create($payload);
            // dd($payload);
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
            //   Lấy ra payload và format lai
            $slide = $this->slideRepository->findById($id);
            $slideItem = $slide->item;
            unset($slideItem[session('currentLanguage')]);

            $payload = request()->only('name', 'keyword', 'setting', 'short_code');
            $payload['keyword'] = Str::slug($payload['keyword']);
            $payload['item'] = $this->handleSildeItem(request('slide')) + $slideItem;

            $this->slideRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    private function handleSildeItem($slides = [])
    {
        $payload = [];
        foreach ($slides['image'] as $key => $value) {
            $payload[session('currentLanguage')][] = [
                'image' => $value,
                'description' => $slides['description'][$key],
                'canonical' => $slides['canonical'][$key],
                'window' => $slides['window'][$key] ?? '',
                'name' => $slides['name'][$key],
                'alt' => $slides['alt'][$key],
            ];
        }
        return $payload;
    }


    public function destroy($id)
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

    public function dragUpdate($data = [])
    {
        DB::beginTransaction();
        try {
            //   Lấy ra data và format lai
            $id = $data['id'];
            $currentLanguage = session('currentLanguage');

            $slide = $this->slideRepository->findById($id);
            $slideItem = $slide->item[$currentLanguage];

            // Cập nhật các ảnh mới vào mục của slide
            foreach ($data['image'] as $key => $image) {
                $slideItem[$key]['image'] = $image;
            }
            // dd($slideItem);

            $payload = [
                'item' => [
                    $currentLanguage => $slideItem + $slide->item
                ]
            ];

            // Thực hiện cập nhật slide
            $this->slideRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die;
            return false;
        }
    }


    // Service client
    public function getSlide($keyword = [])
    {
        $result = [];
        $slides = $this->slideRepository->findByWhere([
            'publish' => ['=', config('apps.general.defaultPublish')],
        ], ['*'], [], true, [], [
            'field' => 'keyword',
            'value' => $keyword
        ]);

        foreach ($slides as $key => $slide) {
            $slide->item = $slide->item[session('currentLanguage')];
            $result[$slide->keyword] = $slide;
        }

        return $result;
    }
}
