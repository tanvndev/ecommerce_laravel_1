<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories;

use App\Models\{ModuleTemplate};
use App\Repositories\Interfaces\{ModuleTemplate}RepositoryInterface;

class {ModuleTemplate}Repository extends BaseRepository implements {ModuleTemplate}RepositoryInterface
{
    protected $model;
    public function __construct(
        {ModuleTemplate} $model
    ) {
        $this->model = $model;
    }

    public function get{ModuleTemplate}LanguageById($id = 0, $languageId = 0)
    {
        $select = [
            '{table}_catalogues.id',
            '{table}_catalogues.parent_id',
            '{table}_catalogues.publish',
            '{table}_catalogues.image',
            '{table}_catalogues.icon',
            '{table}_catalogues.album',
            '{table}_catalogues.follow',
            'tb2.name',
            'tb2.description',
            'tb2.content',
            'tb2.meta_keyword',
            'tb2.meta_title',
            'tb2.meta_description',
            'tb2.canonical',
        ];
        return $this->model
            ->select($select)
            ->join('{table}_catalogue_language as tb2', '{table}_catalogues.id', '=', 'tb2.{table}_catalogue_id')
            ->where('tb2.language_id', $languageId)
            ->find($id);
    }
}
