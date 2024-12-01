@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="header__wrap">
    <h2 class="header__text">会員登録</h2>
</div>

<form class="form__wrap" action="{{ route('register') }}" method="post">
    @csrf

    <div class="form__item">
        <label for="name" class="sr-only">名前</label>
        <input id="name" class="form__input" type="text" name="name" placeholder="名前" value="{{ old('name') }}">
        @error('name')
        <div class="form__error-message">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="form__item">
        <label for="email" class="sr-only">メールアドレス</label>
        <input id="email" class="form__input" type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
        @error('email')
        <div class="form__error-message">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="form__item">
        <label for="password" class="sr-only">パスワード</label>
        <input id="password" class="form__input" type="password" name="password" placeholder="パスワード">
        @error('password')
        <div class="form__error-message">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="form__item">
        <label for="password_confirmation" class="sr-only">確認用パスワード</label>
        <input id="password_confirmation" class="form__input" type="password" name="password_confirmation" placeholder="確認用パスワード">
        @error('password_confirmation')
        <div class="form__error-message">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="form__item">
        <button class="form__button" type="submit">会員登録</button>
    </div>
</form>

<div class="link__wrap">
    <div class="link__item">
        <p class="link__text">アカウントをお持ちの方はこちら</p>
        <a class="link__btn" href="/login">ログイン</a>
    </div>
</div>

@endsection