<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use App\Models\Product;
use App\Models\CartItem;
 
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
 
        return view('cart', compact('cart', 'total'));
    }
 
    // カートに商品を追加
    public function add(Request $request, int $id)
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

        // if (Auth::check()) {
        if (true) {
            $this->sessionCartToDatabase(Auth::id(), $cart);
        }

        return redirect('/cart')->with('success', 'カートに商品を追加しました！');
    }
 
    // カートから商品を削除
    public function remove($id)
    {
        $cart = session()->get('cart', []);
 
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            if (Auth::check()) {
                $this->sessionCartToDatabase(Auth::id(), $cart);
            }
        }
 
        return redirect('/cart')->with('success', 'カートから商品を削除しました。');
    }

    protected function sessionCartToDatabase(int $userId, array $sessionCart)
    {
        if (empty($sessionCart)){
            try {
            DB::transaction(function () use ($userId) {
                CartItem::where('user_id', $userId)->delete();
            });
            } catch (\Throwable $e){
                Log::error('Failed to delete DB cart items', ['userId' => $userId, 'error' => $e->getMessage()]);
                throw $e;
            }

            return ;
        }

        DB::transaction(function () use ($userId, $sessionCart) {
            $productIds = array_map('intval', array_keys($sessionCart));

            $existing = CartItem::where('user_id', $userId)
                ->whereIn('product_id', $productIds)
                ->get()
                ->keyBy('product_id');

            $toInsert = [];
            $toUpdateMap = [];

            foreach ($sessionCart as $productId => $data) {
                $productId = (int)$productId;
                $qty = max(0, (int)($data['quantity'] ?? 0));
                if ($qty === 0) {
                    continue;
                }

                if (isset($existing[$productId])) {
                    $toUpdateMap[$productId] = $existing[$productId]->quantity + $qty;
                } else {
                    $toInsert[] = [
                        'user_id' => $userId,
                        'product_id' => $productId,
                        'quantity' => $qty,
                    ];
                }
            }

            if (!empty($toInsert)) {
                CartItem::insert($toInsert);
            }

            foreach ($toUpdateMap as $productId => $newQty) {
                CartItem::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->update(['quantity' => $newQty]);
            }
        });
    }
}