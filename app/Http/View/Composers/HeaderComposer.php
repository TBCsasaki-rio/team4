<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;

class HeaderComposer {
    
    // header.blade.phpにデータを注入
    public function compose(View $view){

        // ヘッダーに入れるデータをキャッシュに一時保存（60分）
        // 毎回読みこみ処理が行われることを避けるため
        $categories = Cache::remember('header_categories', 10 * 60, function(){
            return Category::get();
        });

        // viewと変数を紐づけ
        $view->with('categories', $categories);
    }
}