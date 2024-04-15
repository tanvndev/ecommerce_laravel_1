<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Menu extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'menus';
    protected $fillable = [
        'parent_id',
        'menu_catalogue_id',
        'left',
        'right',
        'level',
        'image',
        'icon',
        'type',
        'album',
        'publish',
        'order',
        'user_id',
    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'menu_language', 'menu_id', 'language_id')
            ->withPivot(
                'name',
                'canonical',
            )->withTimestamps();
    }


    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function menu_catalogues()
    {
        return $this->belongsToMany(MenuCatalogue::class, 'menu_catalogue_menu', 'menu_id', 'menu_catalogue_id');
    }
    public function menu_catalogue_language()
    {
        return $this->belongsTo(MenuCatalogue::class, 'menu_catalogue_id', 'id');
    }
}
