<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'fullname',
        'email',
        'phone',
        'description',
        'rate',
        'publish',
        'parent_id',
        'left',
        'right',
        'level'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
}
