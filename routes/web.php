<?php

use App\Http\Controllers\Admin\CarouselController as AdminCarouselController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('product.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix("product")->group(function(){
    Route::get("/index", [ProductController::class, 'index']);
    Route::get("/", [ProductController::class, 'index'])->name("product.index");
    Route::get("/add_product", [ProductController::class, 'add_product_page'])->name("product.add");
    Route::post("/add_product", [ProductController::class, 'store'])->name('product.store');
    Route::get("/single/{id}/{var_id?}", [ProductController::class, 'single'])->name('product.single');
    Route::get("/single/{id}/{var_id}", [ProductController::class, 'single_cat'])->name('product.single.cat');
    Route::get("/single/{id}/{var_id?}/personalized", [ProductController::class, 'personalized'])->name('product.personalized');
    Route::get("/single/{id}/{var_id?}/personalized/buy", [ProductController::class, 'buyProductPage'])->name('product.buy');

    Route::get('/category', [CategoryController::class, 'index'])->name('product.category');
    Route::post('/category', [CategoryController::class, 'store']);


});

Route::post('/confirm-buy', [ProductController::class, 'confirm_buy'])->name('confirm-buy');

Route::prefix("user")->group(function(){
    Route::get('/signup', fn()=>view('user.signup'))->name('user.signup');
    Route::get('/login', fn()=>view('user.login'))->name('user.login');
});


Route::middleware('auth')->prefix('admin')->as('admin.')->group(function() {

    Route::middleware('is_admin')->group(function () {
        Route::get('/index', fn()=>view('admin.index'))->name('/');

        // Carousel Routes
        Route::get('/carousel', [AdminCarouselController::class, 'index'])->name('carousel');
        Route::post('/carousel', [AdminCarouselController::class, 'store']);
        Route::delete('/carousel/{id}', [AdminCarouselController::class, 'destroy'])->name('carousel.destroy');

        // Product Routes
        Route::get('/product', [AdminProductController::class, 'index'])->name('product.all');
        Route::get('/product/create', [AdminProductController::class, 'create'])->name('product.add');
        Route::post('/product', [AdminProductController::class, 'store'])->name('product.store');

        // Category Routes
        Route::get('/product/category', [AdminCategoryController::class, 'index'])->name('product.category.index');
        Route::post('/product/category', [AdminCategoryController::class, 'store'])->name('product.category.store');
        Route::get('/product/category/{id}', [AdminCategoryController::class, 'show'])->name('product.category.show');
        Route::get('/product/category/{id}/edit', [AdminCategoryController::class, 'edit'])->name('product.category.edit');
        Route::put('/product/category/{id}', [AdminCategoryController::class, 'update'])->name('product.category.update');
        Route::delete('/product/category/{id}', [AdminCategoryController::class, 'destroy'])->name('product.category.destroy');

        // Product Detail Routes (must come after category routes to avoid conflicts)
        Route::get('/product/{id}', [AdminProductController::class, 'show'])->name('product.show');
        Route::get('/product/{id}/edit', [AdminProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{id}', [AdminProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{id}', [AdminProductController::class, 'destroy'])->name('product.destroy');

        // Product Variation Routes
        Route::get('/product/{id}/variations', [AdminProductController::class, 'variations'])->name('product.variations');
        Route::post('/product/{id}/variations', [AdminProductController::class, 'storeVariation'])->name('product.variations.store');
        Route::put('/product/{id}/variations', [AdminProductController::class, 'updateVariations'])->name('product.variations.update');
        Route::put('/product/{id}/variations/single', [AdminProductController::class, 'updateSingleVariation'])->name('product.variations.update-single');
        Route::delete('/product/{id}/variations', [AdminProductController::class, 'deleteVariation'])->name('product.variations.delete');
        Route::post('/product/{id}/variations/reorder', [AdminProductController::class, 'reorderVariations'])->name('product.variations.reorder');

        // Order Routes
        Route::get('/order', [AdminOrderController::class, 'index'])->name('orders');
        Route::get('/order/{id}', [AdminOrderController::class, 'show'])->name('order.show');
        Route::put('/order/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('order.update.status');
        Route::delete('/order/{id}', [AdminOrderController::class, 'destroy'])->name('order.destroy');
    });

});


require __DIR__.'/auth.php';

