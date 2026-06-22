<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート</title>
    <link rel="stylesheet" href="{{ asset('resources/css/style.css') }}">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1 class="mb-4">カート</h1>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($cart))
        <div class="card p-5 text-center">
            <p class="fs-5 text-muted">カートは空です。</p>
            <div class="mt-3">
                <a href="/" class="btn btn-primary">ショッピングを続ける</a>
            </div>
        </div>
    @else
        <div class="card shadow-sm p-4">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>商品名</th>
                        <th style="width: 15%;">価格</th>
                        <th style="width: 10%;">数量</th>
                        <th style="width: 15%;">小計</th>
                        <th style="width: 10%;">操作</th>
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
                                <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <a href="/" class="btn btn-outline-secondary">買い物を続ける</a>
                </div>
                <div class="text-end">
                    <h3 class="mb-3">合計金額: <span class="text-danger">{{ number_format($total) }}円</span></h3>
                    <a href="/checkout" class="btn btn-success btn-lg px-4">レジに進む</a>
                </div>
            </div>
        </div>
    @endif
</div>

</body>
@include('footer')