<?php

namespace App\Overwrites;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use YangJiSen\CacheUserProvider\UserObserver;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'cache-user');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('custom-cache', function ($app, $config) {
            return new CacheUserProvider(
                $app['hash'],
                $config['model'],
                config('cache-user.cache_ttl', 3600)
            );
        });

        foreach (config('auth.providers') as $provider) {
            if ($provider['driver'] === 'custom-cache') {
                $provider['model']::observe(UserObserver::class);
            }
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('cache-user.php'),
        ], 'cache-user');
    }
}
