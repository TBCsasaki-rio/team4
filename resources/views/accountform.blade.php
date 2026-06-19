<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>会員登録</title>
<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
    <header>
        <h1>SayYou</h1>
    </header>

    <main>
        <h3>会員新規登録</h3>

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

            <table border="1">
                <tr>
                    <th>お名前</th>
                    <td>
                        <input type="text" name="name" value="{{ $name }}">
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td>
                        <input type="password" name="password">
                    </td>
                </tr>
            </table>

            <button>登録</button>
        </form>
    </main>

    <hr>


</body>
</html>