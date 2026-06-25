<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class AdminController extends Controller
{
//     Route::get('/admin', [AdminController::class, 'index']);
// Route::get('/backyard', [AdminController::class, 'backyard']);
// Route::get('/backyard',[AdminController::class, 'productEdit']);
// Route::get('/orderd', [AdminController::class, 'orderd']);
    public function index() {
        return view('admin.index');
    }

    public function backyard() {

        $products = Product::get();

        return view('admin.backyard',compact('products'));
    }

    public function productEdit($id){
        
        $product = Product::find($id);
        return view('admin.editProduct',compact('product'));
    }

    public function productUpdate($id, Request $request){

        $product = Product::find($id);
        $categoryId = $request->input('categoryId');
        $name = $request->input('name');
        $price = $request->input('price');

        // if (Category::where('id', $categoryId)->exists() === false){
        //     echo "エラー？？？？";
        //     return redirect('/backyard')->with('cateoryError', "カテゴリIDが存在しません");
        // }

        $product->category_id = $categoryId;
        $product->name = $name;
        $product->price = $price;

        $product->save();
        
        return redirect('/admin');
    }

    public function ordered() {
        $orders = Order::get();

        return view('admin.ordered', compact('orders'));
    }
}
