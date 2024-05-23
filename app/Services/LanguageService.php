<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\LanguageServiceInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class LanguageService extends BaseService implements LanguageServiceInterface
{
    protected $languageRepository;
    public function __construct(LanguageRepository $languageRepository)
    {
        parent::__construct();
        $this->languageRepository = $languageRepository;
    }
    function paginate()
    {
        $condition = [
            'keyword' => addslashes(request('keyword')),
            'publish' => request('publish'),
        ];
        $languages = $this->languageRepository->pagination(
            ['id', 'name', 'image', 'publish', 'canonical', 'user_id'],
            $condition,
            request('perpage'),

        );
        // dd($languages->links());
        return $languages;
    }


    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token');
            // Lấy ra id của người dùng hiện tại.
            $payload['user_id'] = Auth::id();
            $create =  $this->languageRepository->create($payload);

            if (!$create) {
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

    public function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');
            $update =  $this->languageRepository->update($id, $payload);

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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm
            $delete =  $this->languageRepository->delete($id);

            if (!$delete) {
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


    public function saveTranslate($id)
    {

        DB::beginTransaction();
        try {
            // Lấy ra payload
            $option = request('option');
            $payloadLanguage = $this->payloadLanguage($option, $id);


            // Lấy ra đối tượng repository tương ứng
            $repositoryInstance = $this->getRepositoryInstance($option['model']);

            // Lấy ra model tương ứng
            $model = $repositoryInstance->findById($id);
            // Xoá và tạo ra pivot
            $this->detachAndCreatePivot($model, $repositoryInstance, $option, $payloadLanguage);


            // Xoá router cũ
            $this->routerRepository->forceDeleteByWhere([
                'module_id' => ['=', $id],
                'controllers' => ['=', 'App\Http\Controllers\Clients\\' . ucfirst($option['model']) . 'Controller'],
                'language_id' => ['=', $option['languageId']]
            ]);
            // Thêm router mới
            $router = [
                'canonical' => Str::slug(request('translate_canonical')),
                'module_id' => $id,
                'language_id' => $option['languageId'],
                'controllers' => 'App\Http\Controllers\Clients\\' . ucfirst($option['model']) . 'Controller'
            ];

            $this->routerRepository->create($router);


            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }



    private function detachAndCreatePivot($model, $repositoryInstance,  $option, $payloadLanguage)
    {
        // Xoá bản ghi cũa một pivot
        $model->languages()->detach([$option['languageId']], $model->id);
        // Tạo ra pivot 
        $repositoryInstance->createPivot($model, $payloadLanguage, 'languages');
    }

    private function payloadLanguage($option, $id)
    {
        $payloadLanguage = [
            'name' => request('translate_name'),
            'content' => request('translate_content'),
            'description' => request('translate_description'),
            'meta_title' => request('translate_meta_title'),
            'meta_keyword' => request('translate_meta_keyword'),
            'meta_description' => request('translate_meta_description'),
            'canonical' => Str::slug(request('translate_canonical')),
            $this->convertModelToId($option['model']) => $id,
            'language_id' => $option['languageId'],
        ];

        return $payloadLanguage;
    }

    private function convertModelToId($model)
    {
        $idName = strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $model));
        return $idName . '_id';
    }

    public function switch($canonical)
    {
        DB::beginTransaction();
        try {
            // Update ngôn ngữ vừa chọn thành 1 và chuyển tất cả ngon ngữ còn lại thành 0
            $this->languageRepository->updateByWhere(['canonical' => ['=', $canonical]], ['current' => 1]);
            $this->languageRepository->updateByWhere(['canonical' => ['<>', $canonical]], ['current' => 0]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }
}
