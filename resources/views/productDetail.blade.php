<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
    <link rel="stylesheet" href="/css/products_style.css">
</head>

<body>
    <!-- header.php を読み込む -->
    @include('header')

    <hr>

    <div class="layout-wrapper">

        <main class="main-content">

            <div class="content-header">
                <div>対象商品数：<strong>120</strong> アイテム</div>
                <select class="sort-select">
                    <option>新着順</option>
                    <option>価格が安い順</option>
                    <option>価格が高い順</option>
                </select>
            </div>

            <div class="product-list" id="product-list">
                @foreach($products as $product)
                <div class="product">
                    <a href="/products/{{$product['id']}}">
                        <img
                            src="/image/products/{{$product['id']}}/{{ $product->mainImage->url }}"
                            alt="商品画像"
                            class="product-image">
                    </a>
                    <div class="product-details">
                        <h2>{{$product['name']}}</h2>
                        <p>{{$product['price']}}円</p>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
        
    </div>

    <hr>

    <!-- footer.php を読み込む -->
    @include('footer')

</body>
@include('footer')