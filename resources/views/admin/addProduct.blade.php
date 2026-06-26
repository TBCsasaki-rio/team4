<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/home_logo.jpg') }}" type="image/jpeg">

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
                    <div id="image_preview_container" style="display: none;">
                        <img id="image_preview" src="" alt="画像プレビュー" style="max-width: 200; max-height: 200px;">
                    </div>
                    <input type="file" name="image" id="image"
                        accept="image/*" required>
                </td>
            </tr>
        </table>

        <button>登録</button>
    </form>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();
            const previewContainer = document.getElementById('image_preview_container');
            const previewImage = document.getElementById('image_preview');

            // ファイルが選択されている場合のみプレビューを表示
            if (file) {
                reader.readAsDataURL(file);
                reader.onload = function(event) {
                    previewContainer.style.display = 'block'; // コンテナを表示
                    previewImage.src = event.target.result; // 画像のソースを設定
                };
            } else {
                previewContainer.style.display = 'none'; // コンテナを非表示
                previewImage.src = ''; // 画像のソースをクリア
            }
        });
    </script>
</body>

</html>