<?php

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


Route::prefix('admin')->as('admin.')->group(function() {

    Route::get('/index', fn()=>view('admin.index'))->name('/');

    Route::get('/carousel', [CarouselController::class, 'index'])->name('carousel');
    Route::post('/carousel', [CarouselController::class, 'store']);

    Route::get('/product', [ProductController::class, 'admin_index'])->name('product.all');
    Route::get('/product/add', [ProductController::class, 'admin_add_product'])->name('product.add');
    Route::post('/product/add', [ProductController::class, 'admin_store']);


});


require __DIR__.'/auth.php';

