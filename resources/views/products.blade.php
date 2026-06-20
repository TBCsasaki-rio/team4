<!DOCTYPE html>
<html>
    
<head>
<meta charset="UTF-8">
<title>商品一覧</title>
<link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <!-- header.php を読み込む -->
    @include('header')

    <hr>

    <nav>
        <form action="/products/search" method="post">
            @csrf
            <input type="text" name="keyword" placeholder="商品名" value="{{ old('keyword') }}">
            <input type="number" name="maxprice" placeholder="価格">
            <button>検索</button>
        </form>

        <a href="/products.php">全商品</a>

        <!-- カテゴリ一覧 -->
        @foreach ($categories as $category)
            <a href="/products?categoryId={{ $category['id'] }}"
               style="margin-right: 5px;">
               {{ $category['name'] }}
            </a>
        @endforeach
        <a href="/cart" style="padding-left: 10px;">カートを見る</a>
    </nav>

    <main>
        <table>
            <tr>
                <th>NO</th>
                <th>商品名</th>
                <th>値段</th>
                <th></th>
            </tr>

            @foreach ($products as $product)
                <tr>
                    <td>{{ $product['id'] }}</td>

                    <td>
                        <a href="/products/{{ $product['id'] }}">
                            {{ $product['name'] }}
                        </a>
                    </td>

                    <td>{{ $product['price'] }}円</td>

                    <td>
                        <form action="/cart_add" method="post">
                            @csrf
                            <input type="hidden" name="productId" value="{{ $product['id'] }}">
                            <button>カートに追加</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </table>
    </main>

    <hr>

    <!-- footer.php を読み込む -->
    @include('footer')

</body>
</html>
