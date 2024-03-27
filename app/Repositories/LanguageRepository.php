<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    protected $model;
    public function __construct(
        Language $model
    ) {
        $this->model = $model;
    }

    public function getCurrentLanguage()
    {
        $locale = app()->getLocale();
        $language = $this->findByWhere(['canonical' => ['=', $locale]], ['id']);
        return $language->id;
    }
}
