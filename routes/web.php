<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
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
    Route::get("/single/{id}", [ProductController::class, 'single'])->name('product.single');
    Route::get("/single/{id}/personalized", [ProductController::class, 'personalized'])->name('product.personalized');
    Route::get("/single/{id}/personalized/buy", [ProductController::class, 'buyProductPage'])->name('product.buy');

    Route::get('/category', [CategoryController::class, 'index'])->name('product.category');
    Route::post('/category', [CategoryController::class, 'store']);
});

Route::prefix("user")->group(function(){
    Route::get('/signup', fn()=>view('user.signup'))->name('user.signup');
    Route::get('/login', fn()=>view('user.login'))->name('user.login');
});

require __DIR__.'/auth.php';

