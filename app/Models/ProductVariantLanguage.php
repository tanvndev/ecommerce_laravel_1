<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantLanguage extends Model
{
    use HasFactory;

    protected $table = 'product_variant_language';
    protected $fillable = [
        'product_variant_id',
        'language_id',
        'name',
    ];
}
