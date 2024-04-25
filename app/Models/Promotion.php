<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Promotion extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'promotions';
    protected $fillable = [
        'name',
        'type',
        'method',
        'code',
        'discount_infomation',
        'publish',
        'start_at',
        'end_at',
        'never_end',
        'order',
        'description'
    ];

    protected $casts = [
        'discount_infomation' => 'json',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_product_variant', 'promotion_id', 'product_id')->withPivot(
            'variant_uuid',
            'model',
        )->withTimestamps();
    }
}
