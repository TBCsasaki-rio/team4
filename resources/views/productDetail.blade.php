<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/titleLogo.jpg') }}" type="image/jpeg">
    <title>商品詳細</title>
    <link rel="stylesheet" href="/css/productDetail_style.css">
</head>

<body>
    <!-- header.php を読み込む -->
    @include('header')

    <div class="layout-wrapper">
        <div class="product">
            <div class="product-image">
                <div class="main-image">
                    <a href="/products/{{$product['id']}}">
                        <img
                            src="/images/product_images/{{$product->mainImage->url}}"
                            alt="商品画像"
                            class="product-image">
                    </a>
                </div>

                @isset($subImages)
                <div class="sub-image-list">
                    @foreach($subImages as $image)
                    <img src="/image/products/{{$product['id']}}/{{$image['url']}}?text=sub+1" class="active" alt="サブ画像">
                    @endforeach
                </div>
                @endisset
            </div>

            <div class="product-details">
                <div class="detail-header">
                    <h2 class="product-title">{{$product['name']}}</h2>
                </div>
                <div class="product-price-area">
                    <span class="price-value">{{$product['price']}}円</span>
                    <span class="price-tax"> (税込) </span>
                </div>

                <div class="action-area">
                    <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="post">
                        @csrf
                        <button class="btn-add-cart">カートに入れる</button>
                    </form>
                    <form action="/favariteAdd" method="post">
                        @csrf
                        <button class="btn-favorite">♥ お気に入りに追加</button>
                    </form>
                </div>

                <div class="product-specs">
                    <h3>商品仕様</h3>
                    <table>
                        <tr>
                            <th>カテゴリー</th>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <th>納期</th>
                            <td>ご注文から約3営業日以内に発送</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="return">
            <form action="/products" method="get">
                @csrf
                <button type="submit" class="returnBtn">戻る</button>
            </form>
        </div>
    </div>

    <!-- footer.php を読み込む -->
    @include('footer')

</body>
