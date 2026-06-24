<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/titleLogo.jpg') }}" type="image/jpeg">
    <title>注文完了</title>

    {{-- CSS --}}   
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <hr>

    <main>
        <h3>ご注文ありがとうございました。</h3>
       
        <br>

        {{-- ✅ 商品一覧へ戻るボタン --}}
        <a href="/products">
            <button type="button">商品一覧へ戻る</button>
        </a>

    </main>

    <hr>

</body>
@include('footer')