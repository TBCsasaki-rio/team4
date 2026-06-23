<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Servicies\RankingService;
use Illuminate\Http\Request;
use Ramsey\Collection\Collection;

use function PHPUnit\Framework\isEmpty;

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
            echo ('すみません。商品が見つかりませんでした。');
            return redirect('/products');
        }
        

        return view('productDetail', compact('product'));
    }

    // 1. 商品検索：keyword, maxprice
    // 2. 対象商品を一覧表示
    public function search(Request $request)
    {

        $keyword = $request->input('keyword', null);
        echo $keyword;
        $maxprice = $request['maxprice'];

        if ($keyword === null and $maxprice === null) {
            $searchedProducts = Product::get();
        } else if ($keyword != null and isEmpty($maxprice)) {
            $searchedProducts = Product::where('name', 'Like', "%{$keyword}%")->get();
        } else if ($keyword === null and !isEmpty($maxprice)) {
            $searchedProducts = Product::where('price', '<=', $maxprice)->get();
        } else {
            $searchedProducts =
                Product::where('name', 'Like', "%{$keyword}%")
                ->where('price', '<=', $maxprice)
                ->get();
        }
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
            ->with('products', $searchedProducts)
            ->with('top1product',$top1product);
    }

    // サイドバーの条件をもとにProductにクエリを送り、
    // viewに表示させます
    // 1. checkBoxから☑の付いたvalue配列を受け取る：0to499, 500to1000 など
    // 2. クエリ用に文字列を変換する
    // 3. queryBuilderを作成する
    public function conditionSearch(Request $request)
    {
        $price_ranges = $request->input('filter-price-range', []);
        $category_ids = $request->input('filter-category', []);

        if (count($price_ranges) === 0 and count($category_ids) === 0) {
            return redirect("/products");
        }

        // パースして有効なレンジ集める
        $parsed = [];
        $query = Product::query();

        if (count($price_ranges) > 0) {
            foreach ($price_ranges as $price_range) {
                // 0to499 -> 0, 499 に分けて、変数に格納
                [$minprice, $maxprice] = explode('to', $price_range);
                // is_numeric() 数字であるかを検査
                $minprice = is_numeric($minprice) ? (int)$minprice : null;
                $maxprice = is_numeric($maxprice) ? (int)$maxprice : null;
                // 配列に要素追加
                $parsed[] = ['minprice' => $minprice, 'maxprice' => $maxprice];

                $query->where(function ($q) use ($parsed) {
                    foreach ($parsed as $range) {
                        if ($range['maxprice'] === null) {
                            $q->orWhere('price', '>=', $range['minprice']);
                        } else {
                            $q->orWhereBetween('price', [$range['minprice'], $range['maxprice']]);
                        }
                    }
                });
            }
        }

        if (count($category_ids) > 0) {
            foreach ($category_ids as $category_id) {
                $query->where(function ($q) use ($category_id) {
                    $q->orWhere('category_id', $category_id);
                });
            }
        }

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
