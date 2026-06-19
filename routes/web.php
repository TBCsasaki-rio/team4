<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;   // ログイン・会員登録・ログアウト
use App\Http\Controllers\ProductController;
//Route::get('/', function () {
//    return view('welcome');
//});


// ================================================
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

// 商品：一覧表示
Route::get('/products', [ProductController::class, 'products']);
// 商品：単体表示
Route::get('/products/{id}', [ProductController::class, 'details']);
// 商品：検索
Route::post('/products/search', [ProductController::class, 'search']);
