@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <h1 class="title">| 申請一覧</h1>

    <div class="tabs">
        <a href="{{ route('corrects.index', ['status' => 'pending']) }}" class="tab {{ request('status' , 'pending') == 'pending' ? 'active' : '' }}">承認待ち</a>
        <a href="{{ route('corrects.index', ['status' => 'approved']) }}" class="tab {{ request('status' , 'pending') == 'approved' ? 'active' : '' }}">承認済み</a>
    </div>
    <div class="attendance-header">
        <span>状態</span>
        <span>名前</span>
        <span>対象日時</span>
        <span>申請理由</span>
        <span>申請日時</span>
        <span>詳細</span>
    </div>
    @foreach ($requests as $request)
        <div class="attendance-row">
            <span>
                @if ($request->status === 'pending')
                    承認待ち
                @elseif ($request->status === 'approved')
                    承認済み
                @endif
            </span>
            <span>{{ $request->user->name }}</span>
            <span>{{ \Carbon\Carbon::parse($request->attendance->date)->format('Y/m/d') }}</span>
            <span>{{ $request->note }}</span>
            <span>{{ \Carbon\Carbon::parse($request->created_at)->format('Y/m/d') }}</span>
            <span><a href="{{ route('attendance.show', $request->attendance->id) }}">詳細</a></span>
        </div>
    @endforeach
@endsection
