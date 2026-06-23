
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MailController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/order', [OrderController::class, 'index']);

Route::post('/order', [OrderController::class, 'order']);

Route::get('/ordercomp', [OrderController::class, 'ordercomp']);

Route::get('/products', fn() => view('products'));


Route::post('/order/complete', [MailController::class, 'complete'])
    ->name('order.complete');

