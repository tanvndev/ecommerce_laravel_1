<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MenuCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'menu_catalogues';
    protected $fillable = [
        'name',
        'keyword',
        'publish',
    ];

    public function menus()
    {

        return $this->hasMany(Menu::class, 'menu_catalogue_id', 'id');
    }
}
