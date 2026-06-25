<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/titleLogo.jpg') }}" type="image/jpeg">
    <title>商品一覧</title>
    <link rel="stylesheet" href="/css/products_style.css">
    <style>
        /* --- 画面全体のスクロールを禁止し、高さを固定 --- */
        html, body {
            margin: 0;
            padding: 0;
            height: 100vh;      /* 画面の高さいっぱいに固定 */
            overflow: hidden;   /* 画面全体のスクロールバーを消す */
            display: flex;
            flex-direction: column;
        }

        header {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            text-align: center;
            gap: 20px;
            margin-left: 20%;
            height: 60px;       /* ヘッダーの高さを明示的に固定（適宜調整してください） */
            flex-shrink: 0;     /* ヘッダーが潰れないように固定 */
        }

        .shop-logo img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>
    @include('header')

    <div class="content-layout-wrapper">
        <!-- 値段検索・オススメ商品の欄 -->
        <aside class="sidebar">
            <!-- 値段検索 -->
            <div class="search-price">
                <form action="/products/searchPrice">
                    <span class="label-text" style="color: #ff85a2; font-weight: 600;">値段で検索<br></span>
                    <input name="minprice" value="{{old('minprice')}}" placeholder="下限" size="5">
                    <span class="span-text" style="margin: 0px;">～</span>
                    <input name="maxprice" value="{{old('maxprice')}}" placeholder="上限" size="5">
                    <button class="searchBtn">検索</button>
                </form>
            </div>

            <div class="banner-area">
                <img src="{{ asset('images/recommend.png') }}" alt="recommendLogo" style="max-width: 200px; height:auto;">
                <div class="product" style="width:190px; height: 260px;">
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
                        <h4 style="margin: 3px;">{{$top1product->name}}</h4>
                        <p style="margin: 3px;">{{$top1product->price}}円</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="main-content">
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

            <div class="shopContents">
                <!-- 対象商品数・新着順等のプルダウン -->
                <div class="content-header">
                    <div>対象商品数：<strong>{{count($products)}}</strong> アイテム</div>
                    <select class="sort-select">
                        <option value="new" {{ $currentSort === "new" ? 'selected' : '' }}>新着順</option>
                        <option value="cheape" {{ $currentSort === "cheape" ? 'selected' : '' }}>価格が安い順</option>
                        <option value="expensive" {{ $currentSort === "expensive" ? 'selected' : '' }}>価格が高い順</option>
                    </select>
                </div>

                <!-- 商品一覧 -->
                <div class="product-list" id="product-list">
                    @foreach($products as $product)
                    <div class="product" style="height: 300px;">
                        <a href="/products/{{$product['id']}}">
                            <img
                                src="/images/product_images/{{$product->mainImage->url}}"
                                alt="商品画像"
                                class="product-image">
                        </a>
                        <div class="product-details">
                            <h2 style="margin: 10px;">{{$product['name']}}</h2>
                            <p class="product-price" style="margin: 5px;">{{$product['price']}}円</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

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