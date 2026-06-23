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