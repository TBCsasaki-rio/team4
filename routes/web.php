<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;   // ログイン・会員登録・ログアウト

<<<<<<< HEAD
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
=======
Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart',[CartController::class, 'index']);
>>>>>>> 9db4db2d5dbcc32853ef5cdf23548f95a5aa1411
