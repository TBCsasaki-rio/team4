<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCompletedMail;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'tel' => 'required',
            'email' => 'required|email',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->withErrors(['error' => 'カートが空です']);
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order_id = DB::table('orders')->insertGetId([
                'user_id' => Auth::id() ?? 1,
                'ordered_on' => now(),
                'total_price' => $total
            ]);

            foreach ($cart as $product_id => $item) {
                DB::table('order_items')->insert([
                    'order_id' => $order_id,
                    'product_id' => $product_id,
                    'quantity' => $item['quantity']
                ]);
            }
            // ✅ セッションカート削除
            DB::commit();

            $cartItems = [];
            foreach ($cart as $product_id => $item) {
                // 商品IDを使って products テーブルから商品情報を取得
                $product = DB::table('products')->where('id', $product_id)->first();

                $cartItems[] = [
                    'name'     => $product ? $product->name : '商品名不明', // DBから名前を取得
                    'price'    => $item['price'],
                    'quantity' => $item['quantity'],
                ];
            }

            // メール送信
            $order = (object)[
                'id' => $order_id,
                'name' => $request->name,
                'email' => $request->email,
                'total' => $total,
                'items' => $cartItems,
            ];
            Mail::to($order->email)
                ->send(new OrderCompletedMail($order));

            session()->put('cart', []);

            session(['orderNumber' => $order_id]);

            return redirect('/orderComp');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->withErrors(['error' => '注文処理に失敗']);
        }
    }

    // ✅ セッションに注文番号保存


    public function index()
    {
        $cart = session()->get('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('order', compact('total'));
    }


    // ✅ 注文完了画面（これが追加部分）
    public function orderComp()
    {
        $orderNumber = session('orderNumber');

        return view('orderComp', compact('orderNumber'));
    }
}
