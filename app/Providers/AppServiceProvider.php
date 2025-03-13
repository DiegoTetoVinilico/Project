<?php

namespace App\Providers;

use App\Repositories\CarroRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CarroRepository::class, function ($app) {
            return new CarroRepository(new \App\Models\Carro());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
