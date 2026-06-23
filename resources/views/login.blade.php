<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/titleLogo.jpg') }}" type="image/jpeg">
    <title>ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <main>
            <h1>
                <img src="{{ asset('images/login.jpg') }}" alt="loginLogo" style="max-width: 250px; height:auto;">
            </h1>
            <form action="{{ route('login') }}" method="post">
                
                @csrf

                <table>
                    <tr>
                        <th>ユーザ名</th>
                        <td><input type="text" name="name" placeholder="ユーザ名" value="{{ $name ?? '' }}"></td>
                    </tr>
                    <tr>
                        <th>パスワード</th>
                        <td><input type="password" name="password" placeholder="パスワード"></td>
                    </tr>
                </table>

                <div class="button">
                    <button type="submit">ログイン</button>
                </div>

                @if (!empty($errorList))
                    <ul style="color:red;">
                        @foreach ($errorList as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('register') }}">新規会員登録の方はこちら</a>
            </div>
            
        </main>   
        @include('footer')
    </div>
</body>