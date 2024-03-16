<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PostCatalogue extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
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
            'meta_keywords',
            'description',
            'content'
        )->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post_catalogue_language()
    {
        return $this->belongsTo(PostCatalogue::class, 'post_catalogue_id', 'id');
    }
}
