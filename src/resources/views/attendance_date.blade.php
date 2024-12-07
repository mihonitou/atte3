@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance_date.css') }}">
@endsection

@section('content')
<form class="header__wrap" action="{{ route('attendance') }}" method="get">

    <button class="date__change-button" name="dateChange" value="prev">
        << /button>
            <input type="hidden" name="displayDate" value="{{ $displayDate }}">
            <p class="header__text">{{ $displayDate ? $displayDate->format('Y-m-d') : 'N/A' }}</p>
            <button class="date__change-button" name="dateChange" value="next">></button>
</form>

<div class="table__wrap">
    <table class="attendance__table">
        <tr class="table__row">
            <th class="table__header">名前</th>
            <th class="table__header">勤務開始</th>
            <th class="table__header">勤務終了</th>
            <th class="table__header">休憩時間</th>
            <th class="table__header">勤務時間</th>
        </tr>

        @foreach ($users as $user)
        <tr class="table__row">
            <td class="table__data">{{ $user->name ?? 'N/A' }}</td>
            <td class="table__data">{{ $user->start ?? 'N/A' }}</td>
            <td class="table__data">{{ $user->end ?? 'N/A' }}</td>
            <td class="table__data">{{ $user->total_rest ?? 'N/A' }}</td>
            <td class="table__data">{{ $user->total_work ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- ページネーション --}}
<div class="pagination__container">
    {{ $users->links('vendor/pagination/paginate') }}
</div>
@endsection