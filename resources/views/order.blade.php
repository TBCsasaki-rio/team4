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


            <hr>

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

            {{-- ✅ ルート変更（Laravel controllerへ） --}}
            <form action="/order" method="post">
                @csrf

                <table>
                    <tr>
                        <th>お名前</th>
                        <td>
                            <input type="text" name="name" value="{{ old('name') }}">
                        </td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td>
                            <input type="text" name="address" value="{{ old('address') }}">
                        </td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td>
                            <input type="text" name="tel" value="{{ old('tel') }}">
                        </td>
                    </tr>
                    <tr>
                        <th>e-mail</th>
                        <td>
                            <input type="email" name="email" value="{{ old('email') }}">
                        </td>
                    </tr>
                </table>

            <div class="button">
                <button type="submit">
                    注文する（合計：{{ number_format($total) }}円）
                </button>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('cart') }}">カート画面に戻る</a>
            </div>

            </form>
        </main>
        @include('footer')
    </div>
</body>