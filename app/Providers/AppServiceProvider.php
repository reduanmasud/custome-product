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
        // Register anonymous components from the resources/views/admin/components directory
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin.components');
    }
}
