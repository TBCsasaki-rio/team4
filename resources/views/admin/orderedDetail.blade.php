<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/home_logo.jpg') }}" type="image/jpeg">
    <title>オーダーの一覧</title>
    <style>
        table {
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <h1>オーダー詳細</h1>
    <table border="1">
        <tr>
            <th>商品ID</th>
            <th>商品名</th>
            <th>単価</th>
            <th>数量</th>
            <th>小計</th>
        </tr>
        @foreach($orderItems as $item)
        <tr>
            <td>{{ $item->product_id }}</td>
            <td>{{ $item->product->name ?? '削除された商品' }}</td>
            <td>{{ $item->product->price ?? 0 }} 円</td>
            <td>{{ $item->quantity }} 個</td>
            <td>{{ ($item->product->price ?? 0) * $item->quantity }} 円</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <a href="/admin/ordered">一覧に戻る</a>

</body>

</html>