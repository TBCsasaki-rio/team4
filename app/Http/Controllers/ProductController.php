<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
// Route::get('/products', [ProductController::class], 'products');
// Route::get('/products/search', [ProductController::class], 'search');
// Route::get('/products/{id}', [ProductController::class], 'detail');

    // 商品一覧表示・カテゴリーごとに表示
    public function products(Request $request){

        $categoryId = $request['categoryId'];
        
        if ($categoryId === null){
            $products = Product::get();
        } else {
            $products = Product::where('category_id', $categoryId)->get();
        }

        $categories = Category::get();

        return view('products', compact('products','categories'));
    }

    // 商品詳細
    public function details($id){

        $product = Product::find($id);
        if ($product === null){
            // 商品がなかったとき用のViewに遷移させる
            echo ('すみません。商品が見つかりませんでした。');
            return redirect('/products');
        }

        return view('productDetail')
        ->with('products', $product);
    }

    // 1. 商品検索：keyword, maxprice
    // 2. 対象商品を一覧表示
    public function search(Request $request){

        $keyword = $request->input('keyword',null);
        echo $keyword;
        $maxprice = $request['maxprice'];

        if ($keyword === null and $maxprice === null){
            $searchedProducts = Product::get();
        } else if($keyword != null and isEmpty($maxprice)){
            $searchedProducts = Product::where('name', 'Like', "%{$keyword}%")->get();
        } else if($keyword === null and !isEmpty($maxprice)){
            $searchedProducts = Product::where('price' ,'<=', $maxprice)->get();
        } else {
            $searchedProducts =
             Product::where('name', 'Like', "%{$keyword}%")
                        ->where('price', '<=', $maxprice)
                        ->get();
        }
        
        $categories = Category::get();

        return view('products')
            ->with('products', $searchedProducts)
            ->with('categories', $categories);
    }
}
