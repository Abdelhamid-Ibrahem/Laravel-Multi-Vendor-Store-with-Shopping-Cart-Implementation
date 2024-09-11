<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;


class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();

//         Add your aliases

        $loader->alias('format', \NumberFormatter::class);
        $loader->alias('Currency', \NumberFormatter::class);
        $loader->alias('Currency', \App\Helpers\Currency::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
