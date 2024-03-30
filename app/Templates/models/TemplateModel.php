<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class {ModuleTemplate} extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = '{moduleTemplate}s';
    protected $fillable = [
        'image',
        'follow',
        'album',
        'publish',
        'order',
        'user_id',
        '{moduleTemplate}_catalogue_id'

    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class, '{moduleTemplate}_language', '{moduleTemplate}_id', 'language_id')->withPivot(
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


    public function {moduleTemplate}_catalogues()
    {
        return $this->belongsToMany({ModuleTemplate}Catalogue::class, '{moduleTemplate}_catalogue_{moduleTemplate}', '{moduleTemplate}_id', '{moduleTemplate}_catalogue_id');
    }
    public function {moduleTemplate}_catalogue_language()
    {
        return $this->belongsTo({ModuleTemplate}Catalogue::class, '{moduleTemplate}_catalogue_id', 'id');
    }
}
