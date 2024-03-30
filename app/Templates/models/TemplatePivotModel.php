<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class {ModuleTemplate}CatalogueLanguage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = '{moduleTemplate}_catalogue_language';


    public function {moduleTemplate}_catalogues()
    {
        return $this->belongsTo({ModuleTemplate}Catalogue::class, '{moduleTemplate}_catalogue_id', 'id');
    }
}
