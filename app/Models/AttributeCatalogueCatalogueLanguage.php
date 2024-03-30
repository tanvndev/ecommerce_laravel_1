<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AttributeCatalogueCatalogueLanguage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = '{moduleTemplate}_catalogue_language';


    public function {moduleTemplate}_catalogues()
    {
        return $this->belongsTo(AttributeCatalogueCatalogue::class, '{moduleTemplate}_catalogue_id', 'id');
    }
}
