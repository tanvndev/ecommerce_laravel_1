<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Language extends Model
{

    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, QueryScopes;
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'canonical',
        'image',
        'publish',
        'user_id',
        'current',
        'deleted_at',
    ];

    public function postCatalogues()
    {
        // post_catalogue_language là tên bảng liên kết giũa hai bảng
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_language', 'post_catalogue_id', 'language_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'description',
            'content'
        )->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
