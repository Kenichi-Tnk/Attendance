@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
    <h1> | {{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}の勤怠</h1>
    <div class="pagination">
        <a href="{{ route('admin.attendance.index', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" class="pagination__link pagination__link--prev">前日</a>
        <span class="current-date">
            <i class="fas fa-calendar-alt" style="margin-right:8px;"></i>
            {{ \Carbon\Carbon::parse($date)->format('Y/m/d') }}
        </span>
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
        @foreach($staffs as $staff)
            @php
                $attendance = $attendances->get($staff->id);
            @endphp
            <div class="attendance-row">
                <span>{{ $staff->name }}</span>
                <span>{{ $attendance && $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '00:00' }}</span>
                <span>{{ $attendance && $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '00:00' }}</span>
                <span>{{ $attendance ? $attendance->rest_time : '00:00' }}</span>
                <span>{{ $attendance ? $attendance->total_time : '00:00'}}</span>
                <span><a href="{{ route('admin.attendance.show', $attendance ? $attendance->id : 0) }}" class="btn btn-primary">詳細</a></span>
            </div>
        @endforeach
@endsection
