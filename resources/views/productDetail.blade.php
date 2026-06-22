<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/titleLogo.jpg') }}" type="image/jpeg">
    <title>商品詳細</title>
    <link rel="stylesheet" href="/css/products_style.css">
</head>

<body>

    <!-- header.php を読み込む -->
    @include('header')

    <hr>

    <main>
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
    </main>

    <hr>

    <!-- footer.php を読み込む -->
    @include('footer')

</body>
@include('footer')