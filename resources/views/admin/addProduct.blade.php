<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規商品登録</title>

</head>

<body>
    <h1>新規商品登録</h1>

    <form action="/admin/backyard/add" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <th>カテゴリーID</th>
                <td>
                    <input type="number" name="categoryId">
                </td>
            <tr>
                <th>商品名</th>
                <td>
                    <input type="text" name="name">
                </td>
            </tr>
            <tr>
                <th>価格</th>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>

            <tr>
                <th>メイン商品画像</th>
                <td>
                    <input type="file" name="image" id="image"
                        accept="image/*" required>
                </td>
            </tr>
        </table>

        <button>登録</button>
    </form>
</body>

</html>