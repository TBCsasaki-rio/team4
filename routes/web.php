
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', fn() => view('welcome'));

Route::get('/order', [OrderController::class, 'index']);

Route::post('/order', [OrderController::class, 'order']);

Route::get('/orderComp', fn() => view('orderComp'));
