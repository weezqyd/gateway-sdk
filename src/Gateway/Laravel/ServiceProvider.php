<?php

namespace Roamtech\Gateway\Laravel;

use GuzzleHttp\Client;
use Roamtech\Gateway\Client as Gateway;
use Illuminate\Support\ServiceProvider as RootProvider;
use Roamtech\Gateway\Contracts\CacheStore;
use Roamtech\Gateway\Contracts\ConfigurationStore;
use Roamtech\Gateway\Engine\Core;
use Roamtech\Gateway\Laravel\Stores\LaravelCache;

class ServiceProvider extends RootProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../assets/config/roamtechapi.php' => config_path('roamtechapi.php'),
        ]);
    }

    /**
     * Registrar the application services.
     */
    public function register()
    {
        $this->bindInstances();
        $this->registerFacades();
        $this->mergeConfigFrom(__DIR__ . '/../../../assets/config/roamtechapi.php', 'roamtechapi');
    }

    private function bindInstances()
    {
        $this->app->bind(ConfigurationStore::class, Stores\LaravelConfig::class);
        $this->app->bind(CacheStore::class, LaravelCache::class);
        $this->app->bind(Core::class, function ($app) {
            $config = $app->make(ConfigurationStore::class);
            $cache = $app->make(CacheStore::class);
            $client = new Client([
                'base_uri' => $config->get('roamtechapi.api_endpoint')
            ]);

            return new Core($client, $config, $cache);
        });
    }

    private function registerFacades()
    {
        $this->app->bind('roamtech.client', function () {
            return $this->app->make(Gateway::class);
        });
    }
}
