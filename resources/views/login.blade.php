<?php require '../header.php'; ?>

<body>
    <main>
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

        <a href="{{ route('accountform') }}">新規会員登録の方はこちら</a>
    </main>
</body>