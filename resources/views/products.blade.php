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
        <aside class="sidebar">
            <div class="banner-area">
                <a href="#">
                    <img src="https://via.placeholder.com/250x100/ffdddd/cc0000?text=Summer+Sale" alt="サマーセール">
                </a>
                <a href="#">
                    <img src="https://via.placeholder.com/250x250/ddf0ff/0066cc?text=Diamond+Fair" alt="ダイヤモンドフェア">
                </a>
            </div>

            <div class="filter-box">
                <form action="/products/conditionSearch" method="post">
                    @csrf
                    <h3>条件で絞り込む</h3>

                    <div class="filter-group">
                        <h4>値段</h4>
                        <!-- ToDo:filter-price-rangeをコントローラー側で渡すようにする -->
                        <label class="filter-label"><input type="checkbox" name="filter-price-range[]" value="0to500">0 ～ 499円</label>
                        <label class="filter-label"><input type="checkbox" name="filter-price-range[]" value="500to2000">500 ～ 1000円</label>
                        <label class="filter-label"><input type="checkbox" name="filter-price-range[]" value="1000to5000">1000 ～ 5000円</label>
                        <label class="filter-label"><input type="checkbox" name="filter-price-range[]" value="5000to10000">5000 ～ 10000円</label>
                        <label class="filter-label"><input type="checkbox" name="filter-price-range[]" value="10000toMax">10000円 ～ </label>
                    </div>

                    <div class="filter-group">
                        <h4>カテゴリー</h4>
                        @foreach($categories as $category)
                        <label class="filter-label"><input type="checkbox" name="filter-category[]" value="{{ $category['id'] }}">{{ $category['name'] }}</label>
                        @endforeach
                    </div>
                    <br>
                    <button>この条件で検索</button>
                </form>
            </div>
        </aside>

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

</html>