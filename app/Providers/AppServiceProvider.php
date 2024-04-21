<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    // Khai bao cac service
    protected $serviceBindings = [
        // Base
        'App\Services\Interfaces\BaseServiceInterface' => 'App\Services\BaseService',
        // User
        'App\Services\Interfaces\UserServiceInterface' => 'App\Services\UserService',
        // UserCatalogue
        'App\Services\Interfaces\UserCatalogueServiceInterface' => 'App\Services\UserCatalogueService',
        // Post
        'App\Services\Interfaces\PostServiceInterface' => 'App\Services\PostService',
        // PostCatalogue
        'App\Services\Interfaces\PostCatalogueServiceInterface' => 'App\Services\PostCatalogueService',
        // Language
        'App\Services\Interfaces\LanguageServiceInterface' => 'App\Services\LanguageService',
        // Language
        'App\Services\Interfaces\GenerateServiceInterface' => 'App\Services\GenerateService',
        // Permission
        'App\Services\Interfaces\PermissionServiceInterface' => 'App\Services\PermissionService',
        // ProductCatalogue
        'App\Services\Interfaces\ProductCatalogueServiceInterface' => 'App\Services\ProductCatalogueService',
        // Product
        'App\Services\Interfaces\ProductServiceInterface' => 'App\Services\ProductService',
        // AttributeCatalogue
        'App\Services\Interfaces\AttributeCatalogueServiceInterface' => 'App\Services\AttributeCatalogueService',
        // Attribute
        'App\Services\Interfaces\AttributeServiceInterface' => 'App\Services\AttributeService',
        // System
        'App\Services\Interfaces\SystemServiceInterface' => 'App\Services\SystemService',
        // Menu
        'App\Services\Interfaces\MenuServiceInterface' => 'App\Services\MenuService',
        // Menu
        'App\Services\Interfaces\MenuCatalogueServiceInterface' => 'App\Services\MenuCatalogueService',

        // Slide
        'App\Services\Interfaces\SlideServiceInterface' => 'App\Services\SlideService',
    // Widget
'App\Services\Interfaces\WidgetServiceInterface' => 'App\Services\WidgetService',
// Promotion
'App\Services\Interfaces\PromotionServiceInterface' => 'App\Services\PromotionService',
// Source
'App\Services\Interfaces\SourceServiceInterface' => 'App\Services\SourceService',
// Customer
'App\Services\Interfaces\CustomerServiceInterface' => 'App\Services\CustomerService',
// CustomerCatalogue
'App\Services\Interfaces\CustomerCatalogueServiceInterface' => 'App\Services\CustomerCatalogueService',
];
    public function register(): void
    {
        // 
        foreach ($this->serviceBindings as $key => $value) {
            $this->app->bind($key, $value);
        }

        $this->app->register(AppRepositoryProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
