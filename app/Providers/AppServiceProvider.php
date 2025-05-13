<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register Blade Components
        $this->registerBladeComponents();
    }

    /**
     * Register custom Blade components
     *
     * @return void
     */
    private function registerBladeComponents()
    {
        // Register admin components with the 'admin.components' namespace
        \Illuminate\Support\Facades\Blade::componentNamespace('App\\View\\Components\\Admin', 'admin');

        // Register anonymous components from the resources/views/admin/components directory
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin.components');
    }
}
