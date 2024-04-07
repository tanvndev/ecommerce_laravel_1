<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services;

use App\Services\Interfaces\SystemServiceInterface;
use App\Repositories\Interfaces\SystemRepositoryInterface as SystemRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SystemService implements SystemServiceInterface
{
    protected $systemRepository;
    public function __construct(SystemRepository $systemRepository)
    {
        $this->systemRepository = $systemRepository;
    }

    public function getAll()
    {
        $systems = $this->systemRepository->findByWhere(
            ['language_id' => ['=', session('currentLanguage')]],
            ['keyword', 'content'],
            [],
            true
        );
        $systemsArr = [];

        foreach ($systems as $system) {
            $systemsArr[$system->keyword] = $system->content;
        }

        return $systemsArr;
    }

    public function save()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $configs = request()->input('config');
            $payload = [];
            $languageId = session('currentLanguage');

            foreach ($configs as $key => $value) {
                $payload = [
                    'keyword' => $key,
                    'content' => $value,
                    'user_id' => Auth::id(),
                    'language_id' => $languageId,
                ];
                $condition = ['keyword' => $key, 'language_id' => $languageId];
                $this->systemRepository->updateOrInsert($condition, $payload);
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
