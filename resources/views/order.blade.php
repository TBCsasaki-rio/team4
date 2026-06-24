<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/titleLogo.jpg') }}" type="image/jpeg">
    <title>お客様情報入力</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <main>
            <h1>
                <img src="{{ asset('images/order.jpg') }}" alt="orderLogo" style="max-width: 250px; height:auto;">
            </h1>

            <h3>お客様情報を入力してください</h3>

            {{-- ✅ エラー表示 --}}
            @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/order" method="POST">
                @csrf

                <table>
                    <tr>
                        <th>お名前</th>
                        <td>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="お名前">
                        </td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="住所">
                        </td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td>
                            <input type="text" name="tel" value="{{ old('tel') }}" placeholder="電話番号">
                        </td>
                    </tr>
                    <tr>
                        <th>e-mail</th>
                        <td>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
                        </td>
                    </tr>
                </table>

                <br>

                <button type="submit" class="btn">
                    注文する（合計：{{ number_format($total) }}円）
                </button>
            </form>
        </main>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="/cart">カート画面に戻る</a>
        </div>
        @include('footer')
    </div>
</body>