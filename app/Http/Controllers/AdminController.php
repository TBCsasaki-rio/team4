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
    public function index()
    {
        return view('admin.index');
    }

    public function backyard()
    {

        $products = Product::get();

        return view('admin.backyard', compact('products'));
    }

    public function productAdd()
    {
        return view('admin.addProduct');
    }

    public function productInsert(Request $request)
    {

        $product = new Product();

        $categoryId = $request->input('categoryId');
        $name = $request->input('name');
        $price = $request->input('price');

        $product->category_id = $categoryId;
        $product->name = $name;
        $product->price = $price;

        $product->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // 【修正】同名ファイルの衝突を防ぐため、ファイル名の先頭に現在のタイムスタンプを付与
            $filename = time() . '_' . $image->getClientOriginalName();

            $image->move(public_path('images/product_images'), $filename);

            $path = $filename;


            $product->productImages()->create([
                'url' => $path,
                'is_main' => true,
            ]);
        }

        return redirect('/admin/backyard');
    }

    public function productRemove($id)
    {
        $product = Product::find($id);

        if ($product) {
            // 1. 紐づく画像ファイルを public フォルダから物理削除
            $images = $product->productImages;
            foreach ($images as $image) {
                // public_path() を使って絶対パスを生成
                $filePath = public_path($image->url);

                // ファイルが実際に存在していれば削除
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // 2. データベースから画像データを削除
            $product->productImages()->delete();

            // 3. 商品本体を削除
            $product->delete();
        }

        return redirect('/admin/backyard');
    }

    public function productEdit($id)
    {

        $product = Product::find($id);
        return view('admin.editProduct', compact('product'));
    }

    public function productUpdate($id, Request $request)
    {

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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();

            $image->move(public_path('images/product_images'), $filename);
            $newPath = 'images/product_images/' . $filename;

            $oldImage = $product->mainImage;

            if ($oldImage) {
                $oldFilePath = public_path('images/product_images/'.$oldImage->url);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
                
                $oldImage->update([
                    'url' => $filename,
                ]);
            } else {
                $product->productImages()->create([
                    'url' => $filename,
                    'is_main' => true,
                ]);
            }
        }

        return redirect('/admin');
    }

    public function ordered()
    {
        $orders = Order::get();

        return view('admin.ordered', compact('orders'));
    }

    public function orderedDetail($id)
    {
        $order = Order::find($id);
        $orderItems = $order->orderItems;

        return view('admin.orderedDetail', compact('orderItems'));
    }
}
