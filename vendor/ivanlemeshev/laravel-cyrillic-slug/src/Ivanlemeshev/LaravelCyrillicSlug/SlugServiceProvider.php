<?php namespace Ivanlemeshev\LaravelCyrillicSlug;

use Illuminate\Support\ServiceProvider;

class SlugServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('ivanlemeshev/laravel-cyrillic-slug');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Slug', 'Ivanlemeshev\LaravelCyrillicSlug\Facades\Slug');
        });

        $this->app['laravel-cyrillic-slug'] = $this->app->share(function($app) {
            return new Slug;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
