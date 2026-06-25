<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Servicies\RankingService;
use Illuminate\Http\Request;
use Ramsey\Collection\Collection;


class ProductController extends Controller
{
    protected RankingService $rankingService;

    public function __construct(RankingService $rankingService)
    {
        $this->rankingService = $rankingService;
    }

    // 商品一覧表示・カテゴリーごとに表示
    public function products(Request $request)
    {

        $categoryId = $request->input('categoryId', null);
        $sortOption = $request->input('sort', null);

        $query = Product::query();
        if ($categoryId != null) {
            $query->where('category_id', $categoryId);
        }

        if ($sortOption != null) {
            switch ($sortOption) {
                case ("new"):
                    // $query->orderBy('created_at');
                    break;
                case ("cheape"):
                    $query->orderBy('price', 'asc');
                    break;
                case ("expensive"):
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    break;
            }
        }

        $products = $query->get();
        $categories = Category::get();

        // ランキングTop10をキャッシュから取得。クエリ中は更新処理をしない
        $force = $request->query('force_update', false);
        $top1product = $this->rankingService->getTopByPurchaseCount(1, (bool)$force)->first();

        if ($top1product === null) {
            $top1product = Product::first();
        }

        return view('products', compact('products', 'categories', 'top1product'))
            ->with('currentSort', $sortOption);
    }

    // 商品詳細
    public function details($id)
    {
        $product = Product::find($id);
        if ($product === null) {
            return redirect('/products');
        }

        return view('productDetail', compact('product'));
    }

    // 1. 商品検索：keyword
    // 2. 対象商品を一覧表示
    public function search(Request $request)
    {
        $keyword = $request->input('keyword', null);
        $query = Product::query();

        if (!empty($keyword)) {
            $query->where('name', 'Like', "%{$keyword}%");
        }
        $products = $query->get();

        // 現在選択中のソート条件を取得
        $currentSort = $request->input('sort', "new");

        // カテゴリー一覧取得
        $categories = Category::get();

        // ランキングTop10をキャッシュから取得。クエリ中は更新処理をしない
        $force = $request->query('force_update', false);
        $top1product = $this->rankingService->getTopByPurchaseCount(1, (bool)$force)->first();

        if ($top1product === null) {
            $top1product = Product::first();
        }

        return view('products')
            ->with('categories', $categories)
            ->with('currentSort', $currentSort)
            ->with('products', $products)
            ->with('top1product', $top1product);
    }

    // サイドバーの条件をもとにProductにクエリを送り、
    // viewに表示させます
    // 1. checkBoxから☑の付いたvalue配列を受け取る：0to499, 500to1000 など
    // 2. クエリ用に文字列を変換する
    // 3. queryBuilderを作成する
    public function searchPrice(Request $request)
    {
        $minprice = $request->input('minprice');
        $maxprice = $request->input('maxprice');
        $query = Product::query();

        // is_numeric() 数字であるかを検査
        $minprice = is_numeric($minprice) ? (int)$minprice : null;
        $maxprice = is_numeric($maxprice) ? (int)$maxprice : null;

        $range = ['minprice' => $minprice, 'maxprice' => $maxprice];

        if ($range['minprice'] === null and $range['maxprice'] === null){
            return redirect('/products');
        }

        $query->where(function ($q) use ($range) {
            if ($range['maxprice'] === null) {
                $q->orWhere('price', '>=', $range['minprice']);
            } else if ($range['minprice'] === null) {
                $q->orWhere('price', '<=', $range['maxprice']);
            } else {
                $q->orWhereBetween('price', [$range['minprice'], $range['maxprice']]);
            }
        });

        $products = $query->get();
        $categories = Category::get();
        $currentSort = $request->input('sort', "new");

        // ランキングTop10をキャッシュから取得。クエリ中は更新処理をしない
        $force = $request->query('force_update', false);
        $top1product = $this->rankingService->getTopByPurchaseCount(1, (bool)$force)->first();

        if ($top1product === null) {
            $top1product = Product::first();
        }

        //デバッグ用にコメントアウトしています。
        return view("products", compact('products', 'categories', 'top1product', 'currentSort'));
    }
}
