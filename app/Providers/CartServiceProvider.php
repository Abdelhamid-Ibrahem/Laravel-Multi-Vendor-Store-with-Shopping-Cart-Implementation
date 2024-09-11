<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(CartModelRepository::class, function () {
            return new CartModelRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
