<head>
    <style>

        header {
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        header .categories {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 10px;
        }

    </style>
</head>

<header>
    <h1 class="shop-title">SAY YOU!!ユージーン店</h1>
    <nav>
        <form action="/products/search" method="post">
            @csrf
            <input type="text" name="keyword" placeholder="商品名" value="{{ old('keyword') }}">
            <input type="number" name="maxprice" placeholder="価格">
            <button>検索</button>
        </form>

        <!-- カテゴリ一覧 -->
        <div class="categories">
            <div class="category">
                <a href="/products">全商品</a>
            </div>

            @foreach ($categories as $category)
            <div class="category">
                <a href="/products?categoryId={{ $category['id'] }}"
                    style="margin-right: 5px;">
                    {{ $category['name'] }}
                </a>
            </div>
            @endforeach
        </div>

        <a href="/cart" style="padding-left: 10px;">カートを見る</a>
</header>
