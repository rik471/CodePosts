<?php


namespace CodePress\CodePosts\Providers;

use Illuminate\Support\ServiceProvider;

class CodePostServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../resources/migrations/'=> base_path('database/migrations')], 'migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/codepost', 'codepost');
        require __DIR__ . '/../routes.php';
    }

    /**
     *Register the service provider.
     *
     * @return void
     */

    public function register()
    {

    }
}