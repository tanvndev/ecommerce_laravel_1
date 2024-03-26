<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;

class PostCatalogue extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, QueryScopes;
    protected $table = 'post_catalogues';
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
        return $this->belongsToMany(Language::class, 'post_catalogue_language', 'post_catalogue_id', 'language_id')->withPivot(
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

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_catalogue_post', 'post_catalogue_id', 'post_id');
    }

    public function post_catalogue_language()
    {
        return $this->hasMany(PostCatalogueLanguage::class, 'post_catalogue_id', 'id');
    }

    // Hàm này giúp kiểm tra có  danh  mục con hay không.
    public static function isChildrenNode($id = 0)
    {
        $postCatalogue = self::find($id);

        if (empty($postCatalogue)) {
            return false;
        }

        // Kiểm tra nếu right - left > 1 thì không có danh mục con
        if (($postCatalogue->right - $postCatalogue->left) > 1) {
            return false;
        }

        return true;
    }
}
