
<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;   // ログイン・会員登録・ログアウト
use App\Http\Controllers\AdminController;
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
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// オーダー機能
Route::get('/order', [OrderController::class, 'index']);
Route::post('/order', [OrderController::class, 'order']);

Route::get('/orderComp', [OrderController::class, 'orderComp']);
Route::post('/orderComp', [MailController::class, 'complete']);

// Admin Index
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/backyard', [AdminController::class, 'backyard']);
Route::get('/admin/ordered', [AdminController::class, 'ordered']);
// Admin 商品管理
Route::get('/admin/backyard/add', [AdminController::class, 'productAdd']);
Route::post('/admin/backyard/add', [AdminController::class, 'productInsert']);

Route::post('/admin/backyard/remove/{id}', [AdminController::class, 'productRemove'])->name('backyard.remove');

Route::get('/admin/backyard/edit/{id}',[AdminController::class, 'productEdit'])->name('backyard.edit');
Route::post('/admin/backyard/edit/{id}',[AdminController::class, 'productUpdate'])->name('backyard.update');
// Admin オーダー
Route::get('/admin/orderd/detail/{id}', [AdminController::class, 'orderedDetail'])->name('orderd.detail');