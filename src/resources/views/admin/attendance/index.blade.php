@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1> <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}の勤怠</h1>
    <div class="date-navigation">
        <a href="{{ route('admin.attendance.index', ['date' => \Carbon\Carbon::parse($date)->subDay()->toDateString()]) }}" class="btn btn-secondary">前日</a>
        <span class="current-date">
            <i class="fa fa-calendar"></i> {{ $date }}
        </span>
        <a href="{{ route('admin.attendance.index', ['date' => \Carbon\Carbon::parse($date)->addDay()->toDateString()]) }}" class="btn btn-secondary">翌日</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>名前</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->user->name }}</td>
                    <td>{{ $attendance->clock_in }}</td>
                    <td>{{ $attendance->clock_out }}</td>
                    <td>{{ $attendance->rest_time }}</td>
                    <td>{{ $attendance->total_time }}</td>
                    <td>
                        <a href="{{ route('admin.attendance.show', $attendance->id) }}" class="btn btn-primary">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
