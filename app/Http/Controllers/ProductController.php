<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Ramsey\Collection\Collection;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    // 商品一覧表示・カテゴリーごとに表示
    public function products(Request $request)
    {

        $categoryId = $request['categoryId'];

        if ($categoryId === null) {
            $products = Product::with('mainImage')->get();
        } else {
            $products = Product::with('mainImage')->where('category_id', $categoryId)->get();
        }

        $categories = Category::get();

        return view('products', compact('products', 'categories'));
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

        return view('products')
            ->with('products', $searchedProducts);
    }

    // サイドバーの条件をもとにProductにクエリを送り、
    // viewに表示させます
    // 1. checkBoxから☑の付いたvalue配列を受け取る：0to499, 500to1000 など
    // 2. クエリ用に文字列を変換する
    // 3. queryBuilderを作成する
    public function conditionSearch(Request $request)
    {
        $price_ranges = $request->input('filter-price-range',[]);

        if (count($price_ranges) === 0){
            return redirect("/products");
        }

        // パースして有効なレンジ集める
        $parsed = [];
        foreach ($price_ranges as $price_range){
            // 0to499 -> 0, 499 に分けて、変数に格納
            [$minprice, $maxprice] = explode('to', $price_range);
            // is_numeric() 数字であるかを検査
            $minprice = is_numeric($minprice) ? (int)$minprice : null;
            $maxprice = is_numeric($maxprice) ? (int)$maxprice : null;
            // 配列に要素追加
            $parsed[] = ['minprice' => $minprice, 'maxprice' => $maxprice];
        }

        // $query = Product::query();
        // $query->where(function ($q) use ($parsed) {
        //     foreach ($parsed as $range){
        //         if ($range['maxprice'] === null){
        //             $q->orWhere('price', '>')
        //         }
        //     }
        // });
        // 条件をもとにクエリを作成します
        $queryBuilder = "";
        $maxprice = 0;
        $minprice = 0;
        if (count($price_ranges) === 1) {
            [$minprice, $maxprice]  = explode("to", $price_ranges[0]);
            $filtered_products = Product::whereBetween('price', [$minprice, $maxprice])->get();
            echo $filtered_products;
        } else {

            // indexと値を同時に取得
            foreach ($price_ranges as $index => $price_range) {
                [$minprice, $maxprice]  = explode("to", $price_ranges[$index]);
                if ($index === 0) {
                    $queryBuilder .= "Product::whereBetween('price', [$minprice, $maxprice])";
                }
                $queryBuilder .= "->orWhereBetween('price'," . "[" . $minprice . "," . $maxprice . "])";
            }
            $queryBuilder .= "->get()";
        }

        // foreach($price_ranges as $price_range){
        //     // WhereBetween('price', [$min, $max])->orWhereBetween(///)->get();
        // }


        //デバッグ用にコメントアウトしています。
        // return redirect("/products");
    }
}
