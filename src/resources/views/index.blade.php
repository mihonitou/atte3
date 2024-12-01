@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="header__wrap">
    <p class="header__text">
        {{ Auth::user()->name }}さんお疲れ様です！
    </p>
</div>

<form class="form__wrap" action="{{ route('work') }}" method="post">
    @csrf

    {{-- 勤務開始ボタン --}}
    <div class="form__item">
        <input type="checkbox" id="start_work" name="start_work" class="form__item-input"
            @if ($status !==0) disabled @endif>
        <label for="start_work" class="form__item-button">勤務開始</label>
    </div>

    {{-- 勤務終了ボタン --}}
    <div class="form__item">
        <input type="checkbox" id="end_work" name="end_work" class="form__item-input"
            @if ($status !==1) disabled @endif>
        <label for="end_work" class="form__item-button">勤務終了</label>
    </div>

    {{-- 休憩開始ボタン --}}
    <div class="form__item">
        <input type="checkbox" id="start_rest" name="start_rest" class="form__item-input"
            @if ($status !==1) disabled @endif>
        <label for="start_rest" class="form__item-button">休憩開始</label>
    </div>

    {{-- 休憩終了ボタン --}}
    <div class="form__item">
        <input type="checkbox" id="end_rest" name="end_rest" class="form__item-input"
            @if ($status !==2) disabled @endif>
        <label for="end_rest" class="form__item-button">休憩終了</label>
    </div>
</form>
@endsection