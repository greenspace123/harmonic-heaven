<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VercelCacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Настраиваем кэш на использование array драйвера в production
        if ($this->app->environment('production')) {
            config(['cache.default' => 'array']);
            config(['cache.stores.array' => ['driver' => 'array']]);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Очищаем кэш конфигурации при каждом запросе в production
        if ($this->app->environment('production')) {
            config(['app.compile' => true]);
        }
    }
}
