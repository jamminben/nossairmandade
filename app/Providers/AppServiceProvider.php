<?php

namespace App\Providers;

use App\Enums\LinkSections;
use App\Models\Link;
use App\Models\MediaSource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $churches = Link::where('section_id', LinkSections::CHURCHES)->with('translations')->orderByRaw('RAND()')->take(6)->get();
        view()->share('footerChurches', $churches);

        $officialSites = Link::where('section_id', LinkSections::OFFICAL)->with('translations')->orderByRaw('RAND()')->take(6)->get();
        view()->share('footerOfficialSites', $officialSites);

        $mediaSources = MediaSource::join('media_source_translations', 'media_sources.id', '=', 'media_source_translations.media_source_id')
            ->where('media_source_translations.language_id', 2)
            ->orderBy('media_source_translations.description')
            ->get();

        // Sharing is caring
        view()->share('allMediaSources', $mediaSources);

        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }
}
