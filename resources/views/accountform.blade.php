<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/titleLogo.jpg') }}" type="image/jpeg">
    <title>新規会員登録</title>
    <link rel="stylesheet" href="{{ asset('resources/css/style.css') }}">
</head>

<body>
    <main>
        <h1>
            <img src="{{ asset('images/newAccount.jpg') }}" alt="newAccountLogo" style="max-width: 250px; height:auto;">
        </h1>

        <form action="{{ route('register') }}" method="post">
            @csrf
            <!-- エラー表示 -->
            @if (!empty($errorList))
                <ul class="error" style="color: red;">
                    @foreach ($errorList as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <table>
                <tr>
                    <th>お名前</th>
                    <td>
                        <input type="text" name="name" placeholder="ユーザ名" value="{{ $name }}">
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td>
                        <input type="password" name="password" placeholder="パスワード">
                    </td>
                </tr>
            </table>

            <br>
            <button>登録</button>
         </form>   
        
         <a href="{{ route('login') }}">ログイン画面に戻る</a>
            
    </main>
</body>
@include('footer')