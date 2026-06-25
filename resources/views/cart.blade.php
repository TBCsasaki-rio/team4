<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート</title>
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>

<body>
    @include('header')
    <div class="cart">
        <h1 class="tableTitle" style="color: #ff85a2;">カート</h1>

        @if(session('success'))
        <div class="alertSuccess">
            {{ session('success') }}
        </div>
        @endif

        @if(empty($cart))
        <div class="card p-5 text-center">
            <p class="nullMsg" style="font-weight: 700; font-size: 20px; color: red; margin-top: 0px; margin-bottom: 5px;">カートは空です</p>
            <img src="{{ asset('images/nullCart.png') }}" alt="nullCartLogo" style="max-width: 250px; height:auto; margin-bottom:30px;">
            <div class="mt-3">
                <a href="/products" class="btn btn-primary">ショッピングを続ける</a>
            </div>
        </div>
        @else
        <div class="card shadow-sm p-4 table-responsive">
            <table class="cartTable">
                <thead class="table-dark">
                    <tr>
                        <th>商品名</th>
                        <th style="width: 15%;">価格</th>
                        <th style="width: 10%;">数量</th>
                        <th style="width: 15%;">小計</th>
                        <th style="width: 10%;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $details)
                    <tr>
                        <td><strong>{{ $details['name'] }}</strong></td>
                        <td>{{ number_format($details['price']) }}円</td>
                        <td>{{ $details['quantity'] }}</td>
                        <td>{{ number_format($details['price'] * $details['quantity']) }}円</td>
                        <td>
                            <form action="{{ route('cart.remove', ['id' => $id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                                @csrf
                                <button type="submit" class="deleteBtn">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    <tfoot>
                        <tr class="total">
                            <td colspan="5" class="text-center" style="border-top: 3px solid #d8ecff; border-bottom: none; background-color: #edf5ff; padding: 20px;">
                                <h2 style="color: #2b6cb0; margin: 0; font-weight: bold;">合計金額：{{ number_format($total) }}円</h2>
                            </td>
                        </tr>
                    </tfoot>
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <a href="/products" class="btn btn-outline-secondary">買い物を続ける</a>
                </div>
                <br>
                <div class="text-end">
                    <a href="/order" class="btn btn-success btn-lg px-4">レジに進む</a>
                </div>
            </div>
        </div>
        @endif
    </div>

    @include('footer')
</body>