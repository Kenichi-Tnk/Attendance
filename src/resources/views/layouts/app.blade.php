<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH勤怠アプリ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>

<body>
    <header>
        <a class="header-link" href="/">
            <img class="header-logo" src="{{ asset('images/logo.png') }}" alt="COACHTECH">
        </a>
            <nav class="header-nav">
                <ul class="header-list">
                    @if (!Request::is('login') && !Request::is('register'))
                        @if (Auth::check) && (Auth::user()->is_admin)
                            <!-- 管理者用リンク -->
                            <li><a href="{{ route('admin.attendance.index') }}">勤怠一覧</a></li>
                            <li><a href="{{ route('admin.staff.index') }}">スタッフ一覧</a></li>
                            <li><a href="{{ route('admin.requests.index') }}">申請一覧</a></li>
                        @else
                            <!-- スタッフ用リンク -->
                            <li><a href="{{ route('attendance.create') }}">勤怠</a></li>
                            <li><a href="{{ route('attendance.index') }}">勤怠一覧</a></li>
                            <li><a href="{{ route('requests.index') }}">申請</a></li>
                        @endif
                        @if (Auth::check())
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit">ログアウト</button>
                                </form>
                            </li>
                        @endif
                    @endif
                </ul>
            </nav>
    </header>
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
</body>
</html>