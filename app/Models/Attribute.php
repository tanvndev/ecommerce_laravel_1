<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Attribute extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'attributes';
    protected $fillable = [
        'image',
        'follow',
        'album',
        'publish',
        'order',
        'user_id',
        'attribute_catalogue_id'

    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'attribute_language', 'attribute_id', 'language_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content',
        )->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function attribute_catalogues()
    {
        return $this->belongsToMany(AttributeCatalogue::class, 'attribute_catalogue_attribute', 'attribute_id', 'attribute_catalogue_id');
    }
    public function attribute_catalogue_language()
    {
        return $this->belongsTo(AttributeCatalogue::class, 'attribute_catalogue_id', 'id');
    }

    public function attribute_language()
    {
        return $this->hasMany(AttributeLanguage::class, 'attribute_id', 'id');
    }
}
