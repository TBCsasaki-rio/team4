<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>

    <h2>ご注文ありがとうございます</h2>

    <p>お名前：{{ $order->name }}</p>
    <p>合計金額： {{ number_format($order->total) }} 円</p>

    <h3>ご注文明細</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;">

        <tr>
            <th style="text-align: left;">商品名</th>
            <th>価格</th>
            <th>数量</th>
            <th>小計</th>
        </tr>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td style="text-align: right;">{{ number_format($item['price']) }} 円</td>
            <td style="text-align: center;">{{ $item['quantity'] }}</td>
            <td style="text-align: right;">{{ number_format($item['price'] * $item['quantity']) }} 円</td>
        </tr>
        @endforeach
    </table>
</body>

</html>