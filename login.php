<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <h1>やばいYシャツ屋さん</h1>
    </header>

    <main>
        <form action="/login.php" method="post">
            <table>
                <tr>
                    <th>メールアドレス</th>
                    <td><input type="text" name="email" placeholder="メールアドレス"></td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td><input type="password" name="password" placeholder="パスワード"></td>
                </tr>
            </table>

            <br>
            <button>ログイン</button>

            <br>
            <span style="color: red;">
                <?= htmlspecialchars($message) ?>
            </span>
        </form>

        <a href="/account.php">新規会員登録の方はこちら</a>
    </main>

    <?php

    $name=$_POST['name'];   // ユーザ名
    $password=$_POST['password'];   // パスワード

    // 入力データに安全対策を施す
    $name=htmlspecialchars($name,ENT_QUOTES,'UTF-8'); // ユーザ名
    $password=htmlspecialchars($password,ENT_QUOTES,'UTF-8');// パスワード

    // ユーザ名が入力されていない場合
    if($name=='')
        {
            print 'ユーザ名が入力されていません';
        }

    // パスワードが入力されていない場合
    if($password=='')
        {
            print 'パスワードが入力されていません';
        }

    // ログインに失敗した場合
    if($name=='' || $password=='')
        {
            print 'もう一度入力してください';
        }
    else
        {
            
        }

    // メッセージを表示したい場合はここでセット
    // $message = "ログイン失敗しました"; など
    $message = $message ?? "";
    ?>
</body>