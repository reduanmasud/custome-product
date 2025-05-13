<?php

use App\Http\Controllers\Admin\CarouselController as AdminCarouselController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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

        // Category API Routes
        Route::get('/api/category/{id}/has-products', [AdminCategoryController::class, 'checkHasProducts'])->name('api.category.has-products');

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

        // User Management Routes
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Role Management Routes
        Route::get('/roles', [AdminRoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [AdminRoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [AdminRoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}', [AdminRoleController::class, 'show'])->name('roles.show');
        Route::get('/roles/{id}/edit', [AdminRoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [AdminRoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [AdminRoleController::class, 'destroy'])->name('roles.destroy');

        // Permission Management Routes
        Route::get('/permissions', [AdminPermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [AdminPermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [AdminPermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{id}', [AdminPermissionController::class, 'show'])->name('permissions.show');
        Route::get('/permissions/{id}/edit', [AdminPermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{id}', [AdminPermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{id}', [AdminPermissionController::class, 'destroy'])->name('permissions.destroy');
    });

});


require __DIR__.'/auth.php';

