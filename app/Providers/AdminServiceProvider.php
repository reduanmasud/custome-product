<?php

namespace App\Providers;

use App\Interfaces\Services\CarouselServiceInterface;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Services\FileUploadServiceInterface;
use App\Interfaces\Services\OrderServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Services\CarouselService;
use App\Services\CategoryService;
use App\Services\FileUploadService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register file upload service
        $this->app->bind(FileUploadServiceInterface::class, FileUploadService::class);
        
        // Register product service
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        
        // Register category service
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        
        // Register order service
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        
        // Register carousel service
        $this->app->bind(CarouselServiceInterface::class, CarouselService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
