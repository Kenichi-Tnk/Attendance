@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1>申請一覧</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>承認待ち</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ユーザー名</th>
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingCorrects as $correct)
                <tr>
                    <td>{{ $correct->user->name }}</td>
                    <td>{{ $correct->date }}</td>
                    <td>{{ $correct->clock_in }}</td>
                    <td>{{ $correct->clock_out }}</td>
                    <td>{{ $correct->rest_time }}</td>
                    <td>{{ $correct->total_time }}</td>
                    <td>
                        <a href="{{ route('admin.corrects.show', $correct->id) }}" class="btn btn-primary">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>承認済み</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ユーザー名</th>
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach($approvedCorrects as $correct)
                <tr>
                    <td>{{ $correct->user->name }}</td>
                    <td>{{ $correct->date }}</td>
                    <td>{{ $correct->clock_in }}</td>
                    <td>{{ $correct->clock_out }}</td>
                    <td>{{ $correct->rest_time }}</td>
                    <td>{{ $correct->total_time }}</td>
                    <td>
                        <a href="{{ route('admin.corrects.show', $correct->id) }}" class="btn btn-primary">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
