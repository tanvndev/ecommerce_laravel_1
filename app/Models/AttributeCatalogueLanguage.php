<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AttributeCatalogueLanguage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'attribute_catalogue_language';


    public function product_catalogues()
    {
        return $this->belongsTo(AttributeCatalogue::class, 'product_catalogue_id', 'id');
    }
}
