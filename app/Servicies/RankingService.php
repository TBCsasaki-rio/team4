<?php

namespace App\Servicies;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RankingService
{
    // キャッシュキーを作るためのもの
    protected string $cachePrefix = 'products:ranking:purchases';
    // 保存時間
    protected int $cacheTtl;

    public function __construct(int $cacheTtlSeconds = 3600 /*１時間*/)
    {
        $this->cacheTtl = $cacheTtlSeconds;
    }

    // Top10の商品を取得
    public function getTopByPurchaseCount(int $limit = 10, $forceUpdate = false)
    {
        $cacheKey = $this->getCacheKey($limit);

        if ($forceUpdate) {
            // キャッシュの削除；今回はしない設定
            Cache::forget($cacheKey);
        }
        // キャッシュがあればキャッシュを、なければ集計
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($limit) {
            return $this->calculateTopByPurchaseCount($limit);
        });
    }

    protected function calculateTopByPurchaseCount(int $limit = 10)
    {
        // 1) product_id ごとに購入数を集計して上位の id を取得
        $topRows = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit($limit)
            ->get();

        // id の配列を作る（順序を保持するために配列で保持）
        $ids = $topRows->pluck('product_id')->all();

        if (empty($ids)) {
            // 購入履歴が無ければ空のコレクションを返す
            return collect([]); // Product[] 相当（空のコレクション）
        }

        // 2) 取得した id 群で Product モデルを取得（リレーションも読み込む）
        $products = Product::whereIn('id', $ids)
            ->get()
            // 上位順（集計順）に並び替え
            ->sortBy(function ($product) use ($ids) {
                return array_search($product->id, $ids, true);
            });
        return $products;
    }

    protected function getCacheKey(int $limit): string
    {
        return "{$this->cachePrefix}:top{$limit}";
    }
}
