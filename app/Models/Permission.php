<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Permission extends Model
{

    use HasApiTokens, QueryScopes;
    protected $table = 'permissions';
    protected $fillable = [
        'name',
        'canonical',

    ];

    public function user_catalogues()
    {
        return $this->belongsToMany(UserCatalogue::class, 'user_catalogue_permission', 'permission_id', 'user_catalogue_id');
    }
}
