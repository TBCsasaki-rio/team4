<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理</title>
    <style>
        table {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <h1>商品管理画面です</h1>
    
    <a href="/admin/backyard/add">新規登録</a>

    <table border="1">
        <tr>
            <th>商品ID</th>
            <th>カテゴリーID</th>
            <th>商品名</th>
            <th>価格</th>
        </tr>
        
        @foreach($products as $product)
        <tr>
            <td>
                {{$product->id}}
            </td>
            <td>
                {{$product->category_id}}
            </td>
            <td>
                {{$product->name}}
            </td>
            <td>
                {{$product->price}}
            </td>
            <td>
                <form action="{{route('backyard.edit', ['id' => $product->id]) }}" method="get">
                    <button>更新</button>
                </form>
            </td>
            <td>
                <form action="{{route('backyard.remove', ['id' => $product->id]) }}" method="post">
                    @csrf
                    <button>削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>