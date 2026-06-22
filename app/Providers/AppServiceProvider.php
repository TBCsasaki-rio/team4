<?php

namespace App\Providers;

use App\Http\View\Composers\HeaderComposer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // header ビューがレンダリングされる際に HeaderComposer を実行
        View::composer('header', HeaderComposer::class);
    }
}
