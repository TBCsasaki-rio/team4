<head>
    <link rel="icon" href="{{ asset('images/home_logo.jpg') }}" type="image/jpeg">
    <style>
        header {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            text-align: center;
            align-items: center;
            gap: 20px;
            height: 55px;
            margin: 15px 15px 15px 15px;
            justify-content: center;

        }

        .header-search {
            flex: 1;
            max-width: 600px;
        }

        .search-form {
            display: flex;
            width: 100%;
            border: 1px solid;
            border-radius: 4px;
            overflow: hidden;
        }

        .search-input {
            flex: 1;
            padding: 10px 16px;
            font-size: 14px;
            border: none;
            outline: none;
        }

        .searchBtn {
            background-color: #4682b4;
            color: #ffffff;
            border: none;
            padding: 10px;
            font-size: 0.8rem;
            font-weight: bold;
            cursor: pointer;
            border-radius: 8px;
        }

        .header-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .action-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #333333;
            width: 64px;
        }

        .action-icon button {
            background-color: none;
            border: none;
        }

        .action-icon {
            font-size: 20px;
            margin-bottom: 4px;
            position: relative;
        }

        .action-text {
            font-size: 10px;
            white-space: nowrap;
            text-decoration: underline;
        }

        .cart-badge {
            position: absolute;
            /* アイコンの中央に配置するための設定 */
            top: 20%;
            /* 上からの位置。画像によって 30% や 50% に微調整してください */
            left: 50%;
            /* 左から50%（中央） */
            transform: translate(-50%, -50%);
            /* 基準点を文字のド真ん中にズラす */

            color: #f08804;
            /* Amazon風のオレンジ色 */
            font-size: 13px;
            /* アイコンの中に入れるため、少し大きめが見やすいです */
            font-weight: bold;

            /* もしカート画像の色（黒など）と被って見えにくい場合は、白いフチ取り（光彩）をつけると見やすくなります */
            text-shadow:
                -1px -1px 0 #fff,
                1px -1px 0 #fff,
                -1px 1px 0 #fff,
                1px 1px 0 #fff;
        }

        #mypage-toggle {
            background-color: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .mypage-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            width: 220px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            margin-top: 10px;
            text-align: left;
        }

        /* マイページを表示状態にJSで変更 */
        .mypage-dropdown.show {
            display: block;
        }

        .mypage-header {
            padding: 12px 15px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
            font-weight: bold;
            color: #333;
        }

        .mypage-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mypage-menu li a {
            display: block;
            padding: 12px 15px;
            font-size: 13px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .mypage-menu li a:hover {
            background-color: #f0f8ff;
        }

        .mypage-menu .logout-link {
            border-top: 1px solid #eee;
        }
    </style>
</head>

<header>
    <div class="header-logo">
        <!-- 商品一覧画面に遷移する -->
        <a href="/products">
            <img src="{{ asset('images/home_logo.jpg') }}" alt="home_logo" style="max-width: 50px; height:50px;">
        </a>
    </div>

    <div class="header-search">
        <form action="/products/search" method="post" class="search-form" style="display: flex; justify-content: center; align-items: center;">
            @csrf    
            <input type="text" name="keyword" class="search-input" placeholder="商品名" value="{{ old('keyword') }}">
        </form>
    </div>
    <button class="searchBtn">検索</button>

    <div class="header-actions">
        <!-- カート画面に遷移する -->
        <a href="/cart" class="action-item">
            <span class="action-icon">
                <img src="{{ asset('images/shopping_cart.png') }}" alt="shopping_cartLogo" style="max-width: 50px; height: 50px;">
                @if(session('cart'))
                <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </span>
        </a>

        <!-- お気に入り画面に遷移する -->
        <a href="/favorites" class="action-item">
            <span class="action-icon">
                <img src="{{ asset('images/favorite.png') }}" alt="favoriteLogo" style="max-width: 50px; height: 50px;">
            </span>
        </a>

        <!-- マイページ画面に遷移する -->
        <div class="mypage-wrapper" style="position: relative;">
            <button id="mypage-toggle" class="action-item">
                <span class="action-icon">
                    <img src="{{ asset('images/mypage.png') }}" alt="mypageLogo" style="max-width: 50px; height: 50px;">
                </span>
            </button>
            <div id="mypage-box" class="mypage-dropdown">
                @auth
                <div class="mypage-header">ようこそ、{{ Auth::user()->name }}様</div>
                <ul class="mypage-menu">
                    <li><a href="/mypage/profile">会員情報変更</a></li>
                    <li><a href="/mypage/history">注文履歴</a></li>
                    <li><a href="/mypage/settings">設定</a></li>
                </ul>
                
                @endauth

                @guest
                <div class="mypage-header">ようこそ、ゲスト様</div>
                <ul class="mypage-menu">
                    <li><a href="/login">ログイン</a></li>
                    <li><a href="/register">新規会員登録</a></li>
                </ul>
                @endguest
            </div>

        </div>
            
        <!-- ログアウトする -->
        <a href="/login" class="action-item">
            <span class="action-icon">
                <img src="{{ asset('images/logout.png') }}" alt="logoutLogo" style="max-width: 50px; height: 50px;">
            </span>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('mypage-toggle');
            const mypageBox = document.getElementById('mypage-box');

            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // イベントの伝播を防ぐ？
                mypageBox.classList.toggle('show'); // showクラスを付け外しして表示を切り替える
            });

            document.addEventListener('click', function(e) {
                if (!mypageBox.contains(e.target) && !toggleBtn.contains(e.target)) {
                    mypageBox.classList.remove('show');
                }
            });
        });
    </script>
</header>