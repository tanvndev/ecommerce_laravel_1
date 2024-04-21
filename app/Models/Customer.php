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
        'image',
        'follow',
        'album',
        'publish',
        'order',
        'user_id',
        'customer_catalogue_id'

    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'customer_language', 'customer_id', 'language_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content',
        )->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function customer_catalogues()
    {
        return $this->belongsToMany(CustomerCatalogue::class, 'customer_catalogue_customer', 'customer_id', 'customer_catalogue_id');
    }
    public function customer_catalogue_language()
    {
        return $this->belongsTo(CustomerCatalogue::class, 'customer_catalogue_id', 'id');
    }
}
