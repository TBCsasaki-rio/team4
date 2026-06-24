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
    <div class="container">
        <main>
            <h3>ご注文ありがとうございました</h3>
        
            {{-- ✅ 商品一覧へ戻るボタン --}}
            <div style="text-align: center; margin-top: 20px;">
                <a href="/products">
                    <button type="button" class="btn">商品一覧へ戻る</button>
                </a>
            </div>

        </main>
    </div>
    @include('footer')

</body>
