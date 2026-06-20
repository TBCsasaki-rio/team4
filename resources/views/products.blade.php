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
        <div class="product-list" id="product-list">
            @foreach($products as $product)
            <div class="product">
                <a href="/products/{{$product['id']}}">
                    <img src="/image/products/{{$product['id']}}/{{ $product->mainImage->url }}" alt="商品画像" class="product-image">
                </a>
                <div class="product-details">
                    <h2>{{$product['name']}}</h2>
                    <p>{{$product['price']}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <hr>

    <!-- footer.php を読み込む -->
    @include('footer')

</body>
</html>
