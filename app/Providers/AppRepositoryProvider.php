<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $repositoryBindings = [
        // Base
        'App\Repositories\Interfaces\BaseRepositoryInterface' => 'App\Repositories\BaseRepository',
        // User
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\UserRepository',
        // UserCatalogue
        'App\Repositories\Interfaces\UserCatalogueRepositoryInterface' => 'App\Repositories\UserCatalogueRepository',
        // Post
        'App\Repositories\Interfaces\PostRepositoryInterface' => 'App\Repositories\PostRepository',
        // PostCatalogue
        'App\Repositories\Interfaces\PostCatalogueRepositoryInterface' => 'App\Repositories\PostCatalogueRepository',
        // Language
        'App\Repositories\Interfaces\LanguageRepositoryInterface' => 'App\Repositories\LanguageRepository',
        // Language
        'App\Repositories\Interfaces\GenerateRepositoryInterface' => 'App\Repositories\GenerateRepository',
        // Permission
        'App\Repositories\Interfaces\PermissionRepositoryInterface' => 'App\Repositories\PermissionRepository',
        // Province
        'App\Repositories\Interfaces\ProvinceRepositoryInterface' => 'App\Repositories\ProvinceRepository',
        // District
        'App\Repositories\Interfaces\DistrictRepositoryInterface' => 'App\Repositories\DistrictRepository',
        // Router
        'App\Repositories\Interfaces\RouterRepositoryInterface' => 'App\Repositories\RouterRepository',
        // ProductCatalogue
        'App\Repositories\Interfaces\ProductCatalogueRepositoryInterface' => 'App\Repositories\ProductCatalogueRepository',
        // Product
        'App\Repositories\Interfaces\ProductRepositoryInterface' => 'App\Repositories\ProductRepository',
        // AttributeCatalogue
        'App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface' => 'App\Repositories\AttributeCatalogueRepository',
        // Attribute
        'App\Repositories\Interfaces\AttributeRepositoryInterface' => 'App\Repositories\AttributeRepository',
        // ProductVariant
        'App\Repositories\Interfaces\ProductVariantRepositoryInterface' => 'App\Repositories\ProductVariantRepository',
        // ProductVariantLanguage
        'App\Repositories\Interfaces\ProductVariantLanguageRepositoryInterface' => 'App\Repositories\ProductVariantLanguageRepository',
        // ProductVariantAttribute
        'App\Repositories\Interfaces\ProductVariantAttributeRepositoryInterface' => 'App\Repositories\ProductVariantAttributeRepository',
    ];

    public function register(): void
    {
        foreach ($this->repositoryBindings as $key => $value) {
            $this->app->bind($key, $value);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
