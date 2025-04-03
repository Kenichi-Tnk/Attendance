@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1>{{ $user->name }}さんの{{ \Carbon\Carbon::parse($month)->format('Y年m月') }}の勤怠</h1>
    <div class="date-navigation">
        <a href="{{ route('admin.staff.show', ['id' => $user->id, 'month' => \Carbon\Carbon::parse($month)->subMonth()->format('Y-m')]) }}" class="btn btn-secondary">前月</a>
        <span class="current-date">
            <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($month)->format('Y/m') }}
        </span>
        <a href="{{ route('admin.staff.show', ['id' => $user->id, 'month' => \Carbon\Carbon::parse($month)->addMonth()->format('Y-m')]) }}" class="btn btn-secondary">翌月</a>
    </div>
    <a href="{{ route('admin.staff.csv', ['id' => $user->id, 'month' => $month]) }}" class="btn btn-primary">CSV出力</a>
    <table class="table">
        <thead>
            <tr>
                <th>日付</th>
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
                    <td>{{ $attendance->date }}</td>
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