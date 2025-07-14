
<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h2>ログインフォーム</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>メールアドレス：</label>
        <input type="email" name="email" required><br>

        <label>パスワード：</label>
        <input type="password" name="password" required><br>

        <button type="submit">ログイン</button>
    </form>
</body>
</html>

