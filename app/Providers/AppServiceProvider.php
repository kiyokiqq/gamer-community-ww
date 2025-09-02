<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Тут можна реєструвати сервіси, наприклад:
        // $this->app->singleton(SomeService::class, function ($app) { ... });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Тут можна додавати глобальні налаштування, макроси, кастомні директиви Blade тощо
        // Для твоєї системи поки що можна залишити порожнім
    }
}
