<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CustomerCatalogue extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'customer_catalogues';
    protected $fillable = [
        'name',
        'description',
        'publish',
    ];


    public function customers()
    {
        return $this->hasMany(Customer::class, 'customer_catalogue_id', 'id');
    }
}
