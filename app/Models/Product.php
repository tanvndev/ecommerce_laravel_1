<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'products';
    protected $fillable = [
        'image',
        'follow',
        'album',
        'publish',
        'order',
        'user_id',
        'product_catalogue_id',
        'attributeCatalogue',
        'attribute',
        'variant',
        'price',
        'sku',
        'origin'
    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'product_language', 'product_id', 'language_id')->withPivot(
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


    public function product_catalogues()
    {
        return $this->belongsToMany(ProductCatalogue::class, 'product_catalogue_product', 'product_id', 'product_catalogue_id');
    }
    public function product_catalogue_language()
    {
        return $this->belongsTo(ProductCatalogue::class, 'product_catalogue_id', 'id');
    }

    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }
}
