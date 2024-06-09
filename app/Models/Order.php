<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, QueryScopes;
    protected $table = 'orders';
    protected $fillable = [
        'code',
        'fullname',
        'phone',
        'email',
        'province_id',
        'district_id',
        'ward_id',
        'user_id',
        'address',
        'payment_method',
        'description',
        'promotion',
        'cart',
        'customer_id',
        'guest_cookie',
        'confirm',
        'payment',
        'delivery',
        'shipping',
    ];

    public $casts = [
        'promotion' => 'json',
        'cart' => 'json',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot(
            'uuid',
            'name',
            'price',
            'price_sale',
            'quantity',
            'promotion',
            'option',
        )->withTimestamps();
    }

    public function order_payments()
    {
        return $this->hasMany(OrderPayment::class, 'order_id', 'id');
    }
}
