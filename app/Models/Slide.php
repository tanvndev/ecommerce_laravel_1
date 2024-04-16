<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Slide extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'slides';
    protected $fillable = [
        'name',
        'keyword',
        'description',
        'item',
    ];



    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
