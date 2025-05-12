@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-corrects.css') }}">
@endsection

@section('content')
    <h1>| 修正申請詳細</h1>

    <div class="form-group">
        <label for="name">名前</label>
        <div class="form-control-plaintext">{{ $correct->user->name }}</div>
    </div>
    <div class="form-group">
        <label for="date">日付</label>
        <div class="form-control-plaintext">
            <span>{{ \Carbon\Carbon::parse($correct->date)->format('Y年') }}</span>
            <span style="margin-left: 150px;">{{ \Carbon\Carbon::parse($correct->date)->format('m月d日') }}</span>
        </div>
    </div>
    <div class="form-group">
        <label for="clock_in_out">出勤・退勤</label>
        <div class="form-control-plaintext">
            <span>{{ \Carbon\Carbon::parse($correct->clock_in)->format('H:i') }}</span>
            <span style="margin-left: 75px;">~</span>
            <span style="margin-left: 75px;">{{ \Carbon\Carbon::parse($correct->clock_out)->format('H:i') }}</span>
        </div>
    </div>
    @forelse ($correct->rests as $index => $rest)
        <div class="form-group">
            <label for="rest_{{ $index }}">休憩{{ $index + 1 }}</label>
            <div class="form-control-plaintext">
                <span>{{ \Carbon\Carbon::parse($rest->rest_start)->format('H:i') }}</span>
                <span style="margin-left: 75px;">~</span>
                <span style="margin-left: 75px;">{{ \Carbon\Carbon::parse($rest->rest_end)->format('H:i') }}</span>
            </div>
        </div>
    @empty
        <p>休憩データがありません</p>
    @endforelse
    <div class="form-group">
        <label for="note">備考</label>
        <div class="form-control-plaintext">{{ $correct->note }}</div>
    </div>

    <div class="button-container">
        @if ($correct->status === 'pending')
            <form action="{{ route('admin.corrects.approve', $correct->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">承認</button>
            </form>
        @else
            <button class="btn btn-secondary" disabled>承認済み</button>
        @endif
    </div>
@endsection
