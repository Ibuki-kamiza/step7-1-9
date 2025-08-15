
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザーログイン画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            font-family: sans-serif;
            padding: 40px;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
        }
        h2 {
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 28px;
        }
        input[type="text"],
        input[type="password"] {
            margin-bottom: 20px;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-orange {
            background-color: #ffaa00;
            color: white;
            font-weight: bold;
            border: none;
            width: 120px;
            border-radius: 20px;
        }
        .btn-cyan {
            background-color: #00ffff;
            color: black;
            font-weight: bold;
            border: none;
            width: 120px;
            border-radius: 20px;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>ユーザーログイン画面</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="text" name="email" placeholder="アドレス" required>
            <input type="password" name="password" placeholder="パスワード" required>

            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('register') }}" class="btn btn-orange me-2">新規登録</a>
                <button type="submit" class="btn btn-cyan">ログイン</button>
            </div>
        </form>
    </div>
</body>
</html>
