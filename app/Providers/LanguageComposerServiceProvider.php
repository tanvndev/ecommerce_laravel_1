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
        View::composer(['servers.*', 'clients.*'], function ($view) {
            $languageRepository = app(LanguageRepository::class);
            $languages = $languageRepository->findByWhere(
                [
                    'publish' => ['=', config('apps.general.defaultPublish')],
                ],
                ['id', 'name', 'canonical', 'current', 'image'],
                [],
                true
            );
            // dd($languages);
            $view->with('languages', $languages);
        });
    }
}
