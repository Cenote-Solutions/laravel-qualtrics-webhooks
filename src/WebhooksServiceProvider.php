<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks;

use Illuminate\Support\ServiceProvider;

class WebhooksServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $root = dirname(__DIR__);

        $this->mergeConfigFrom("$root/config.php", 'qualtrics-webhooks');

        $publishedRoutes = base_path('routes/qualtrics-webhooks.php');

        $this->publishes([
            "$root/config.php" => config_path('qualtrics-webhooks.php'),
            "$root/routes.php" => $publishedRoutes
        ]);

        // Load default routes if route copy is not published
        if (file_exists($publishedRoutes)) {
            $this->loadRoutesFrom($publishedRoutes);
        } else {
            $this->loadRoutesFrom("$root/routes.php");
        }
    }

    /**
     * Register any services.
     * 
     * @return void
     */
    public function register()
    {
        $this->app->singleton('qualtrics-webhooks', function ($app) {
            return new WebhooksManager(
                $app['config']['qualtrics-webhooks'],
                $app['url'],
                $app['log']
            );
        });

        $this->app->alias('qualtrics-webhooks', WebhooksManager::class);
    }

    /**
     * Get the list of provided services.
     * 
     * @return array
     */
    public function provides()
    {
        return ['qualtrics-webhooks', WebhooksManager::class];
    }
}