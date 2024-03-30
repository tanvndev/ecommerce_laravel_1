<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    use HasFactory, QueryScopes;

    protected $table = 'routers';
    protected $fillable = [
        'canonical',
        'module_id',
        'language_id',
        'controllers'
    ];
}
