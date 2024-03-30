<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GalleryCatalogueLanguage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gallery_catalogue_language';


    public function gallery_catalogues()
    {
        return $this->belongsTo(GalleryCatalogue::class, 'gallery_catalogue_id', 'id');
    }
}
