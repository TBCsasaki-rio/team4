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
            <th>メイン商品画像</th>
            <td>
                <div id="image_preview_container" style="display: {{ $product->mainImage ? 'block' : 'none' }};">
                    <img id="image_preview"
                        src="{{ asset('images/product_images/'.$product->mainImage->url)}}"
                        alt="画像プレビュー"
                        style="max-width: 200px; max-height: 200px;">
                </div>

                <input type="file" name="image" id="image" accept="image/*">
            </td>
            </tr>
        </table>
        <button>更新</button>
    </form>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();
            const previewContainer = document.getElementById('image_preview_container');
            const previewImage = document.getElementById('image_preview');

            if (file) {
                // 新しいファイルが選択されたらプレビューを上書き
                reader.readAsDataURL(file);
                reader.onload = function(event) {
                    previewContainer.style.display = 'block';
                    previewImage.src = event.target.result;
                };
            } else {

            }
        });
    </script>
</body>

</html>