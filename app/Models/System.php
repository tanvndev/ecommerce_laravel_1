<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory, QueryScopes;
    protected $table = 'systems';

    protected $fillable = [
        'id',
        'language_id',
        'keyword',
        'content',
    ];


    public function languages()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
