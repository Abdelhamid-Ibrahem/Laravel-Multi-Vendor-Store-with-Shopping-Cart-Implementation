<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

//    public $bindings = [
//        CartModelRepository::class =>  CartRepository::class,
//    ];

    public function register(): void
    {
//        $this->app->bind(
//            \App\Repositories\Cart\CartRepository::class
//        );
//        $this->app->bind(CartModelRepository::class, function () {
//            return new CartModelRepository();
//        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('filter', function ($attribute, $value, $params) {
            return !in_array(strtolower($value), $params);

        },
            "The value is not  prohibited!!");

        paginator::useBootstrapFour();
        // paginator::defaultView('pagination.custom');

//        $this->app->bind(CartModelRepository::class, function () {
//            return new CartModelRepository();
//        });


    }


}
