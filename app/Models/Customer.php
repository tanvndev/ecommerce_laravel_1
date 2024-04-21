<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'customers';
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'phone',
        'address',
        'province_id',
        'district_id',
        'ward_id',
        'birthday',
        'image',
        'description',
        'user_agent',
        'publish',
        'customer_catalogue_id',
        'ip',

    ];


    public function customer_catalogues()
    {
        return $this->belongsTo(CustomerCatalogue::class, 'customer_catalogue_id', 'id');
    }

    public function sources()
    {
        return $this->belongsTo(Source::class, 'customer_id', 'id');
    }
}
