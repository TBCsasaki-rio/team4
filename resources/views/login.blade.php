<head>
    <link rel="stylesheet" href="{{ asset('resources/css/style.css') }}">
</head>

<body>
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

            <br>
            <button>ログイン</button>

            <br>
            @if (!empty($errorList))
                <ul style="color:red;">
                    @foreach ($errorList as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </form>

        <br>
        <a href="{{ route('register') }}">新規会員登録の方はこちら</a>
    </main>   
</body>
@include('footer')