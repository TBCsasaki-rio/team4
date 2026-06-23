<head>
    <link rel="icon" href="{{ asset('images/home_logo.jpg') }}" type="image/jpeg">
    <style>
        header {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            text-align: center;
            gap: 20px;
            height: 55px;
            margin: 15px 15px 15px 15px;
            justify-content: center;

        }
        
        .shop-logo img{
            width: 130px;
            height: 40px;
        }

        .searchBtn {
            background-color: #4682b4;
            color: #ffffff;
            border: none;
            padding: 4px;
            font-size: 0.8rem;
            font-weight: bold;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
            letter-spacing: 0.1rem;
            box-shadow: 0 4px 12px rgba(135, 206, 250, 0.3);
        }
  </style>
</head>

<header>
    <div class="shop-logo">
        <a href="/products">
            <!-- <img src="{{ asset('images/logo.jpg') }}" alt="home_logo""> -->
            <img src="{{ asset('images/home_logo.jpg') }}" alt="home_logo" style="max-width: 50px; height:50px;">
        </a>
    </div>

    <form action="/products/search" method="post" style="display: flex; justify-content: center; align-items: center;">
        @csrf
        <input type="text" name="keyword" placeholder="商品名" value="{{ old('keyword') }}">
        <input type="number" name="maxprice" placeholder="価格">
        <button class="searchBtn">検索</button>
    </form>

    <a href="/cart" style="padding-left: 10px; display: flex; justify-content: center; align-items: center;">カートを見る</a>
    <a href="/logout" style="padding-left: 10px; display: flex; justify-content: center; align-items: center;">ログアウト</a>
        
</header>