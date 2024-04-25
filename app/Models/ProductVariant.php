<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'product_variants';

    protected $fillable = [
        'uuid',
        'product_id',
        'code',
        'quantity',
        'publish',
        'sku',
        'album',
        'price',
        'barcode',
        'file_name',
        'file_url',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'product_variant_language', 'product_variant_id', 'language_id')->withPivot(
            'name',
        )->withTimestamps();
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_variant_attribute', 'product_variant_id', 'attribute_id');
    }
}
