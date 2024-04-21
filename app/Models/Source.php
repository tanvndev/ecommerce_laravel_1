<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Source extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'sources';
    protected $fillable = [
        'name',
        'keyword',
        'description',
        'publish'
    ];

    public function customers()
    {
        $this->hasMany(Customer::class, 'customer_id', 'id');
    }
}
