<!DOCTYPE html>
<html>
<head>
    <title>メールアドレス確認</title>
</head>
<body>
    <h1>メールアドレス確認</h1>
    <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
    <p>メール認証を完了してください。</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証はこちらから</button>
    </form>
</body>
</html>