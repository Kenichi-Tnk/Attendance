@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/requests.css') }}">
@endsection

@section('content')
    <h1>| 申請一覧</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- 承認待ち・承認済みの切り替え -->
    <div class="tabs">
        <a href="{{ route('admin.corrects.index', ['status' => 'pending']) }}" class="tab {{ request('status') == 'pending' ? 'active' : '' }}">承認待ち</a>
        <a href="{{ route('admin.corrects.index', ['status' => 'approved']) }}" class="tab {{ request('status') == 'approved' ? 'active' : '' }}">承認済み</a>
    </div>

    <!-- 申請一覧テーブル -->
    <table class="requests-table">
        <thead>
            <tr>
                <th>ユーザー名</th>
                <th>状態</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>
                        @if ($request->status === 'pending')
                            承認待ち
                        @elseif ($request->status === 'approved')
                            承認済み
                        @endif
                    </td>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->attendance->date)->format('Y/m/d') }}</td>
                    <td>{{ $request->note }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->created_at)->format('Y/m/d') }}</td>
                    <td>
                        <a href="{{ route('admin.corrects.show', $request->id) }}">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
