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

    public function products(Request $request){

        $categoryId = $request['categoryId'];
        echo $categoryId;
        
        if ($categoryId === null){
            $products = Product::get();
        } else {
            $products = Product::where('category_id', $categoryId)->get();
        }

        $categories = Category::get();

        return view('products', compact('products','categories'));
    }

    public function details($id){
        // view側が配列で処理しているため、result配列を使用
        $products = array();
        array_push($products,Product::find($id));
        
        $categories = Category::get();
  
        if ($products === null || count($products) === 0){
            $products = Product::get();
        }

        return view('/products')
        ->with('products', $products)
        ->with('categories',$categories);
    }

    public function search(Request $request){

        $keyword = $request->input('keyword',null);
        echo $keyword;
        $maxprice = $request['maxprice'];
        // $maxprice = $request->input('maxprice');
        echo $maxprice;

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
