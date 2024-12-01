@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="header__wrap">
    <h2 class="header__text">ログイン</h2>
</div>

<form class="form__wrap" action="{{ route('login') }}" method="post">
    @csrf

    <div class="form__item">
        <label for="email" class="sr-only">メールアドレス</label>
        <input id="email" class="form__input" type="email" name="email" placeholder="メールアドレス">
        <p class="form__error-message">
            @error('email')
            {{ $message }}
            @enderror
        </p>
    </div>

    <div class="form__item">
        <label for="password" class="sr-only">パスワード</label>
        <input id="password" class="form__input" type="password" name="password" placeholder="パスワード">
        <p class="form__error-message">
            @error('password')
            {{ $message }}
            @enderror
        </p>
    </div>

    <div class="form__item">
        <button class="form__button" type="submit">ログイン</button>
    </div>
</form>

<div class="link__wrap">
    <div class="link__item">
        <p class="link__text">アカウントをお持ちでない方はこちらから</p>
        <a class="link__btn" href="/register">会員登録</a>
    </div>
</div>

@endsection