<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>会員登録</title>
<link rel="stylesheet" type="text/css" href="resources/css/style.css">
</head>
<body>
    <header>
        <h1>SayYou</h1>
    </header>

    <main>
        <h3>お客様情報</h3>

        <form action="/account" method="post">
            @csrf

            @if (!empty($errorList))
                <ul class="error">
                    @foreach ($errorList as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

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
                        <input type="text" name="email" value="{{ old('email') }}">
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
