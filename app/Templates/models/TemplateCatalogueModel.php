<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class {ModuleTemplate} extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = '{tableName}';
    protected $fillable = [
        'parent_id',
        'left',
        'right',
        'level',
        'image',
        'icon',
        'follow',
        'album',
        'publish',
        'order',
        'user_id',
    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class, '{pivotTable}', '{foreignKey}', 'language_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content'
        )->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function {relation}s()
    {
        return $this->belongsToMany({Relation}::class, '{relationPivot}', '{foreignKey}', '{relation}_id');
    }

    public function {pivotTable}()
    {
        return $this->hasMany({ModuleTemplate}Language::class, '{foreignKey}', 'id')->where('language_id', '=', session('currentLanguage', 1));
    }

    // Hàm này giúp kiểm tra có  danh  mục con hay không.
    public static function isChildrenNode($id = 0)
    {
        ${relation}Catalogue = self::find($id);

        if (empty(${relation}Catalogue)) {
            return false;
        }

        // Kiểm tra nếu right - left > 1 thì không có danh mục con
        if ((${relation}Catalogue->right - ${relation}Catalogue->left) > 1) {
            return false;
        }

        return true;
    }
}
