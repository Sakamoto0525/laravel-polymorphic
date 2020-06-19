<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Tag;
use App\Observers\TagObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Tag::observe(TagObserver::class);
    }
}
