<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Product;
 
class CartController extends Controller
{
    // カート画面の表示
    public function index()
    {
        // セッションからカートのデータを取得
        $cart = session()->get('cart', []);
       
        // 合計金額の計算
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
 
        return view('cart.index', compact('cart', 'total'));
    }
 
    // カートに商品を追加
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
 
        // すでにカートに同じ商品がある場合は数量を増やす
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // 新しくカートに追加
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
 
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'カートに商品を追加しました！');
    }
 
    // カートから商品を削除
    public function remove($id)
    {
        $cart = session()->get('cart', []);
 
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
 
        return redirect()->route('cart.index')->with('success', 'カートから商品を削除しました。');
    }
}