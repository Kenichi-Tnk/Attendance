@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
    <div class="attendance-list">
        <h1 class="title">| 勤怠一覧</h1>

        <div class="pagination">
            <a href="{{ route('user.attendance.list', ['month' => $previousMonth]) }}" class="pagination__link pagination__link--prev">前月</a>
            <span class="pagination__current">{{ $currentMonth }}</span>
            <a href="{{ route('user.attendance.list', ['month' => $nextMonth]) }}" class="pagination__link pagination__link--next">翌月</a>
        </div>

        @foreach ($attendances as $attendance)
            <div class="attendance-row">
                <span>{{ \Carbon\Carbon::parse($attendance->date)->format('n月j日') }}({{ ['日', '月', '火', '水', '木', '金', '土'][\Carbon\Carbon::parse($attendance->date)->dayOfWeek] }})</span>
                <span>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}</span>
                <span>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}</span>
                <span>{{ $attendance->rest_time }}</span>
                <span>{{ $attendance->total_time }}</span>
                <span>
                    <a href="{{ route('attendance.show', $attendance->id) }}">詳細</a>
                </span>
            </div>
        @endforeach
    </div>
@endsection
