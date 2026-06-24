<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        // ✅ バリデーション
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'tel' => 'required',
            'email' => 'required|email',
        ]);

        try {
            DB::beginTransaction();

            $user_id = Auth::check() ? Auth::id() : 1;

            // ✅ カート取得
            $cartItems = DB::table('cart_items as c')
                ->join('products as p', 'c.product_id', '=', 'p.id')
                ->select('c.product_id', 'c.quantity', 'p.price')
                ->where('c.user_id', $user_id)
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception("カートが空です");
            }

            // ✅ 合計計算
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->price * $item->quantity;
            }

            // ✅ orders登録
            $order_id = DB::table('orders')->insertGetId([
                'user_id' => $user_id,
                'ordered_on' => now(),
                'total_price' => $total
            ]);

            // ✅ order_items登録
            foreach ($cartItems as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $order_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ]);
            }

            // ✅ カート削除
            DB::table('cart_items')->where('user_id', $user_id)->delete();
            session()->put('cart', []);

            DB::commit();

            // ✅ セッションに注文番号保存
            session(['orderNumber' => $order_id]);

            return redirect('/orderComp');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => '注文処理に失敗しました']);
        }
    }

    public function index()
    {
        $user_id = Auth::check() ? Auth::id() : 1;

        $cartItems = DB::table('cart_items as c')
            ->join('products as p', 'c.product_id', '=', 'p.id')
            ->select('c.quantity', 'p.price')
            ->where('c.user_id', $user_id)
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('order', compact('total'));
    }

    // ✅ 注文完了画面（これが追加部分）
    public function orderComp()
    {
        $orderNumber = session('orderNumber');

        return view('orderComp', compact('orderNumber'));
    }
    
}
