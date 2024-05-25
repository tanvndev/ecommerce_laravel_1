<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'product_catalogues';
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
        return $this->belongsToMany(Language::class, 'product_catalogue_language', 'product_catalogue_id', 'language_id')->withPivot(
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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_catalogue_product', 'product_catalogue_id', 'product_id');
    }

    public function product_catalogue_language()
    {
        return $this->hasMany(ProductCatalogueLanguage::class, 'product_catalogue_id', 'id')->where('language_id', '=', session('currentLanguage', 1));
    }

    // Hàm này giúp kiểm tra có  danh  mục con hay không.
    public static function isChildrenNode($id = 0)
    {
        $productCatalogue = self::find($id);

        if (empty($productCatalogue)) {
            return false;
        }

        // Kiểm tra nếu right - left > 1 thì không có danh mục con
        if (($productCatalogue->right - $productCatalogue->left) > 1) {
            return false;
        }

        return true;
    }
}
