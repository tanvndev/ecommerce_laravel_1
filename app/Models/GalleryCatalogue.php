<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GalleryCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'gallery_catalogues';
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
        return $this->belongsToMany(Language::class, 'gallery_catalogue_language', 'gallery_catalogue_id', 'language_id')->withPivot(
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

    public function gallerys()
    {
        return $this->belongsToMany(Gallery::class, 'gallery_catalogue_gallery', 'gallery_catalogue_id', 'gallery_id');
    }

    public function gallery_catalogue_language()
    {
        return $this->hasMany(GalleryCatalogueLanguage::class, 'gallery_catalogue_id', 'id')->where('language_id', '=', session('currentLanguage') ?? 1);
    }

    // Hàm này giúp kiểm tra có  danh  mục con hay không.
    public static function isChildrenNode($id = 0)
    {
        $galleryCatalogue = self::find($id);

        if (empty($galleryCatalogue)) {
            return false;
        }

        // Kiểm tra nếu right - left > 1 thì không có danh mục con
        if (($galleryCatalogue->right - $galleryCatalogue->left) > 1) {
            return false;
        }

        return true;
    }
}
