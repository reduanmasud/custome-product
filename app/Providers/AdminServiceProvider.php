<?php

namespace App\Providers;

use App\Interfaces\Repositories\CarouselRepositoryInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\CarouselServiceInterface;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Interfaces\Services\FileUploadServiceInterface;
use App\Interfaces\Services\OrderServiceInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Repositories\CarouselRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
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
        // Register repositories
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CarouselRepositoryInterface::class, CarouselRepository::class);

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
