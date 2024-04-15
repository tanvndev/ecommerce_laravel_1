<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Language extends Model
{

    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'canonical',
        'image',
        'publish',
        'user_id',
        'current',
        'deleted_at',
    ];

    public function post_catalogues()
    {
        // post_catalogue_language là tên bảng liên kết giũa hai bảng
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_language', 'language_id', 'post_catalogue_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content'
        )->withTimestamps();
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_language', 'language_id', 'post_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content'
        )->withTimestamps();
    }

    public function product_catalogues()
    {
        // product_catalogue_language là tên bảng liên kết giũa hai bảng
        return $this->belongsToMany(ProductCatalogue::class, 'product_catalogue_language', 'language_id', 'product_catalogue_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content'
        )->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_language', 'language_id', 'product_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content'
        )->withTimestamps();
    }


    public function attribute_catalogues()
    {
        // attribute_catalogue_language là tên bảng liên kết giũa hai bảng
        return $this->belongsToMany(AttributeCatalogue::class, 'attribute_catalogue_language', 'language_id', 'attribute_catalogue_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content'
        )->withTimestamps();
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_language', 'language_id', 'attribute_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'description',
            'content'
        )->withTimestamps();
    }

    // public function menus()
    // {
    //     return $this->belongsToMany(Menu::class, 'menu_language', 'language_id', 'menu_id')->withPivot(
    //         'name',
    //         'canonical',
    //     )->withTimestamps();
    // }

    public function product_variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_language', 'language_id', 'product_variant_id')->withPivot(
            'name',
        )->withTimestamps();
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
