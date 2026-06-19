<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/account', function () {
    return view('account_form');
});
Route::get('/customer', function () {
    return view('customer_form');
});

