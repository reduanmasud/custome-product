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
        // Register class-based components with the 'admin' namespace
        \Illuminate\Support\Facades\Blade::componentNamespace('App\\View\\Components\\Admin', 'admin');
    }
}
