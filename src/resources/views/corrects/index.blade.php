@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/requests.css') }}">
@endsection

@section('content')
    <h1 class="title">申請一覧</h1>

    <div class="tabs">
        <a href="{{ route('corrects.index', ['status' => 'pending']) }}" class="tab {{ request('status') == 'pending' ? 'active' : '' }}">承認待ち</a>
        <a href="{{ route('corrects.index', ['status' => 'approved']) }}" class="tab {{ request('status') == 'approved' ? 'active' : '' }}">承認済み</a>
    </div>
    <table class="requests-table">
        <thead>
            <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->attendance->date }}</td>
                    <td>{{ $request->reason }}</td>
                    <td>{{ $request->created_at }}</td>
                    <td><a href="{{ route('attendance.show', $request->attendance->id) }}">詳細</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
