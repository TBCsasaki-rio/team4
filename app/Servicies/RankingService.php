<?php
namespace App\Servicies;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class RankingService
{
    // キャッシュキーを作るためのもの
    protected string $cachePrefix = 'products:ranking:purchases';
    // 保存時間
    protected int $cacheTtl;

    public function __construct(int $cacheTtlSeconds = 3600 /*１時間*/) {
        $this->cacheTtl = $cacheTtlSeconds;
    }

    // Top10の商品を取得
    public function getTopByPurchaseCount(int $limit = 10, $forceUpdate = false){
        $cacheKey = $this->getCacheKey($limit);

        if ($forceUpdate){
            // キャッシュの削除；今回はしない設定
            Cache::forget($cacheKey);
        }
        // キャッシュがあればキャッシュを、なければ集計
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($limit) {
            return $this->calculateTopByPurchaseCount($limit);
        });
    }

    protected function calculateTopByPurchaseCount(int $limit = 10){
        $query = Product::select('products.*')
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_qty')
            ->join('order_items', 'order_items.product_id', '=' ,'products.id')
            ->groupBy('products.id')
            ->orderByDesc('total_qty')
            ->with('mainImage')
            ->limit(10);

        return $query->get();
    }

    protected function getCacheKey(int $limit): string {
        return "{$this->cachePrefix}:top{$limit}";
    }
    
}


