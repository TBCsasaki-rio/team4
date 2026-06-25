<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品更新</title>

</head>
<body>
    <h1>商品更新画面です</h1>
    
    <form action="{{route('backyard.update' , ['id' => $product->id]) }}" method="post">
    @csrf
    <table>
        <tr>
            <th>商品ID</th>
            <td>
                {{$product->id}}
            </td>
        </tr>
        <tr>
            <th>カテゴリーID</th>
            <td>
                <input type="number" name="categoryId"
                value="{{$product->category_id}}">
            </td>
        <tr>
            <th>商品名</th>
            <td>
                <input type="text" name="name"
                value="{{$product->name}}">
            </td>
        </tr>
        <tr>
            <th>価格</th>
            <td>
                <input type="number" name="price"
                value="{{$product->price}}">
            </td>
        </tr>
            <td>
                </form>
            </td>
        </tr>
    </table>
    <button>更新</button>
</body>
</html>