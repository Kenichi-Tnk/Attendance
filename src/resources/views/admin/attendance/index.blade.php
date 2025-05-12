@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <h1> <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}の勤怠</h1>
    <div class="pagination">
        <a href="{{ route('admin.attendance.index', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" class="pagination__link pagination__link--prev">前日</a>
        <span class="current-date">{{ \Carbon\Carbon::parse($date)->format('Y/m/d') }}</span>
        <a href="{{ route('admin.attendance.index', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}" class="pagination__link pagination__link--next">翌日</a>
    </div>
    <div class="attendance-header">
        <span>名前</span>
        <span>出勤</span>
        <span>退勤</span>
        <span>休憩</span>
        <span>合計</span>
        <span>詳細</span>
    </div>
        @foreach($attendances as $attendance)
            <div class="attendance-row">
                <span>{{ $attendance->user->name }}</span>
                <span>{{ $attendance->clock_in }}</span>
                <span>{{ $attendance->clock_out }}</span>
                <span>{{ $attendance->rest_time }}</span>
                <span>{{ $attendance->total_time }}</span>
                <span><a href="{{ route('admin.attendance.show', $attendance->id) }}" class="btn btn-primary">詳細</a></span>
            </div>
        @endforeach
@endsection
