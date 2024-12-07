<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header>
        <div class="header__main">
            <h1 class="header__title">Atte</h1>
        </div>

        @if (Auth::check())

        <div class="header__sub">
            <ul class="header__list">
                <li class="header__item">
                    <a class="header__item-link" href="/">{{ __('ホーム') }}</a>
                </li>
                <li class="header__item">
                    <a class="header__item-link" href="{{ route('attendance') }}">{{ __('日付一覧') }}</a>
                </li>
                <li class="header__item">
                    <!-- ログアウトフォーム -->
                    <form action="{{ route('logout') }}" method="post" class="form-inline">
                        @csrf
                        <button type="submit" class="header__item-link button-reset">
                            {{ __('ログアウト') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        @endif

    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <small class="footer__title">Atte, inc.</small>
    </footer>

</body>

</html>