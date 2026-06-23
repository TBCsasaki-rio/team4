<<<<<<< HEAD
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>


    <hr>

    <main>
        <h3>ご注文商品</h3>


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

            <table border="1">
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

            
        <button type="submit">
             注文する（合計：{{ number_format($total) }}円）
        </button>

        </form>
    </main>

    <hr>

</body>
=======
<form action="{{ route('order.complete') }}" method="POST">
    @csrf

    <table border="1">
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

    <br>

    <button type="submit">
        注文する（合計：{{ number_format($total) }}円）
    </button>
</form>
>>>>>>> hamaji2
