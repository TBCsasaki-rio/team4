<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>オーダー 一覧</title>
    <style>
        table {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <h1>オーダー 一覧</h1>
    
    <table border="1">
        <tr>
            <th>オーダーID</th>
            <th>ユーザーID</th>
            <th>注文日</th>
            <th>注文金額</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>
                {{$order->id}}
            </td>
            <td>
                {{$order->user_id}}
            </td>
            <td>
                {{$order->ordered_on}}
            </td>
            <td>
                {{$order->total_price}}
            </td>
            <td>
                <form action="{{route('ordered.detail', ['id' => $order->id]) }}" method="get">
                    <button>詳細</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <a href="/admin">Admin Indexに戻る</a>
</body>
</html>