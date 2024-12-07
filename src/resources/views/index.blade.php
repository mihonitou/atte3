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

<div class="button__container">

    @if (session('message'))
    <div class="alert-success">{{ session('message') }}</div>
    @endif

    @if (session('error'))
    <div class="alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('attendance.startWork') }}">
        @csrf
        <button type="submit" class="button__container-item" {{ $buttonStates['start_work'] ? '' : 'disabled' }}>勤務開始</button>
    </form>

    <form method="POST" action="{{ route('attendance.endWork') }}">
        @csrf
        <button type="submit" class="button__container-item" {{ $buttonStates['end_work'] ? '' : 'disabled' }}>勤務終了</button>
    </form>

    <form method="POST" action="{{ route('attendance.startRest') }}">
        @csrf
        <button type="submit" class="button__container-item" {{ $buttonStates['start_rest'] ? '' : 'disabled' }}>休憩開始</button>
    </form>

    <form method="POST" action="{{ route('attendance.endRest') }}">
        @csrf
        <button type="submit" class="button__container-item" {{ $buttonStates['end_rest'] ? '' : 'disabled' }}>休憩終了</button>
    </form>

</div>

@endsection