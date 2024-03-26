<?php

namespace App\Providers;

use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class LanguageComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\Interfaces\LanguageRepositoryInterface', 'App\Repositories\LanguageRepository');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['servers.*'], function ($view) {
            $languageRepository = app(LanguageRepository::class);
            $languages = $languageRepository->all();
            // dd($languages);
            $view->with('languages', $languages);
        });
    }
}
