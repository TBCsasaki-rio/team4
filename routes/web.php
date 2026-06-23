
<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;   // ログイン・会員登録・ログアウト
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MailController;

// ログイン機能
// ================================================
// ログイン画面の表示
Route::get('/login', [AccountController::class, 'index'])->name('login');
// ログイン処理
Route::post('/login', [AccountController::class, 'login']);


// ================================================
// 会員新規登録機能
// ================================================
// 会員新規登録画面の表示
Route::get('/register', [AccountController::class, 'signUp'])->name('register');
// 新規登録処理
Route::post('/register', [AccountController::class, 'createUser']);

// ================================================
// ログアウト機能
// ================================================
// ログアウト処理
Route::post('/logout', [AccountController::class, 'logout'])->name('logout');

// 商品：
Route::get('/products', [ProductController::class, 'products']);
Route::get('/products/{id}', [ProductController::class, 'details']);
Route::post('/products/search', [ProductController::class, 'search']);
Route::post('/products/conditionSearch', [ProductController::class, 'conditionSearch']);

// カート機能
Route::get('/cart',[CartController::class,'index']);
Route::post('/cartAdd', [CartController::class, 'add']);

// オーダー機能
Route::get('/order', [OrderController::class, 'index']);

Route::post('/order', [OrderController::class, 'order']);

Route::get('/ordercomp', [OrderController::class, 'ordercomp']);

Route::post('/order/complete', [MailController::class, 'complete'])
    ->name('order.complete');

