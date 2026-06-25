<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/titleLogo.jpg') }}" type="image/jpeg">
    <title>商品一覧</title>
    <link rel="stylesheet" href="/css/products_style.css">
    <style>
        header {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            text-align: center;
            gap: 20px;
            margin-left: 20%;
        }

        .shop-logo img {
            width: 50px;
            height: 50px;
        }
    </style>

</head>

<body>

    @include('header')
    <div class="search-price">
        <form action="/products/searchPrice">
            <span class="label-text">値段：<br></span>
            <input name="minprice" value="{{old('minprice')}}" placeholder="下限"><br>
            <span class="span-text">～<br></span>
            <input name="maxprice" value="{{old('maxprice')}}" placeholder="上限"><br>
            <button>検索</button>
        </form>
    </div>

    <!-- カテゴリ一覧 -->
    <div class="tab-wrapper">
        <div class="categories">

            <div class="category {{ !request()->has('categoryId') ? 'active' : ''}}">
                <a href="/products">全商品</a>
            </div>

            @foreach ($categories as $category)
            <div class="category {{ request()->get('categoryId') == $category['id'] ? 'active' : ''}}">
                <a href="/products?categoryId={{ $category['id'] }}"
                    style="margin-right: 5px;">
                    {{ $category['name'] }}
                </a>
            </div>
            @endforeach
        </div>
    </div>


    <div class="content-layout-wrapper">
        <aside class="sidebar">

            <div class="banner-area" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <img src="{{ asset('images/recommend.png') }}" alt="recommendLogo" style="max-width: 230px; height:auto;">
                <div class="product">
                    <div class="badge">
                        <span class="badge top1">TOP1</span>
                    </div>

                    <a href="/products/{{$top1product->id}}">
                        <img
                            src="/images/product_images/{{$top1product->mainImage->url}}"
                            alt="商品画像"
                            class="product-image">
                    </a>
                    <div class="product-details">
                        <h2>{{$top1product->name}}</h2>
                        <p>{{$top1product->price}}円</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="main-content">

            <div class="content-header">
                <div>対象商品数：<strong>{{count($products)}}</strong> アイテム</div>
                <select class="sort-select">
                    <option value="new" {{ $currentSort === "new" ? 'selected' : '' }}>新着順</option>
                    <option value="cheape" {{ $currentSort === "cheape" ? 'selected' : '' }}>価格が安い順</option>
                    <option value="expensive" {{ $currentSort === "expensive" ? 'selected' : '' }}>価格が高い順</option>
                </select>
            </div>


            <div class="product-list" id="product-list">
                @foreach($products as $product)
                <div class="product">
                    <a href="/products/{{$product['id']}}">
                        <img
                            src="/images/product_images/{{$product->mainImage->url}}"
                            alt="商品画像"
                            class="product-image">
                    </a>
                    <div class="product-details">
                        <h2>{{$product['name']}}</h2>
                        <p class="product-price">{{$product['price']}}円</p>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>

    <hr>

    <!-- footer.php を読み込む -->
    @include('footer')

    <script>
        const sortSelect = document.querySelector('.sort-select');

        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortOption = event.target.value;

                if (sortOption === null) return;
                //　現在のURLをもとに取得URLオブジェクトを作成
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sortOption);
                // GETリクエスト
                window.location.href = url.toString();
            });
        }
    </script>

</body>

</html>