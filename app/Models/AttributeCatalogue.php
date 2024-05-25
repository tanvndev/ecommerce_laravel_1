<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AttributeCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'attribute_catalogues';
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
        return $this->belongsToMany(Language::class, 'attribute_catalogue_language', 'attribute_catalogue_id', 'language_id')->withPivot(
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

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_catalogue_attribute', 'attribute_catalogue_id', 'attribute_id');
    }

    public function attribute_catalogue_language()
    {
        return $this->hasMany(AttributeCatalogueLanguage::class, 'attribute_catalogue_id', 'id')->where('language_id', '=', session('currentLanguage', 1));
    }

    // Hàm này giúp kiểm tra có  danh  mục con hay không.
    public static function isChildrenNode($id = 0)
    {
        $attributeCatalogue = self::find($id);

        if (empty($attributeCatalogue)) {
            return false;
        }

        // Kiểm tra nếu right - left > 1 thì không có danh mục con
        if (($attributeCatalogue->right - $attributeCatalogue->left) > 1) {
            return false;
        }

        return true;
    }
}
