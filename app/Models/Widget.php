<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Widget extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'widgets';
    protected $fillable = [
        'name',
        'keyword',
        'album',
        'description',
        'publish',
        'model',
        'model_id',
        'short_code'
    ];

    protected $casts = [
        'model_id' => 'json',
        'album' => 'json',
        'description' => 'json',
    ];
}
