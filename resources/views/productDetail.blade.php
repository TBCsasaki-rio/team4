<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>商品一覧</title>
    <link rel="stylesheet" href="/css/productDetail_style.css">
</head>

<body>
    <!-- header.php を読み込む -->
    @include('header')

    <hr>

    <div class="layout-wrapper">

        <div class="product">
            <div class="product-img-wrapper">
                <a href="/products/{{$product['id']}}">
                    <img
                        src="/image/products/{{$product['id']}}/{{ $product->mainImage->url }}"
                        alt="商品画像"
                        class="product-image">
                </a>
            </div>
            <div class="product-details">
                <h2>{{$product['name']}}</h2>
                <p>{{$product['price']}}円</p>
            </div>
        </div>


    </div>

    <hr>

    <!-- footer.php を読み込む -->
    @include('footer')

</body>
@include('footer')