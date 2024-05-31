<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory, QueryScopes;
    protected $table = 'order_paymantable';
    protected $fillable = [
        'order_id',
        'method_name',
        'payment_id',
        'payment_detail',
    ];

    public $casts = [
        'payment_detail' => 'json',
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
