@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1>修正申請詳細</h1>

    <form action="{{ route('admin.corrects.approve', $correct->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">日付</label>
            <div class="form-control-plaintext">{{ \Carbon\Carbon::parse($correct->date)->format('Y年m月d日') }}</div>
        </div>
        <div class="form-group">
            <label for="clock_in">出勤時間</label>
            <div class="form-control-plaintext">{{ \Carbon\Carbon::parse($correct->clock_in)->format('H:i') }}</div>
        </div>
        <div class="form-group">
            <label for="clock_out">退勤時間</label>
            <div class="form-control-plaintext">{{ \Carbon\Carbon::parse($correct->clock_out)->format('H:i') }}</div>
        </div>
        @foreach ($correct->attendance->rests as $index => $rest)
            <div class="form-group">
                <label for="rest_start_{{ $index }}">休憩{{ $index + 1 }}開始時間</label>
                <div class="form-control-plaintext">{{ \Carbon\Carbon::parse($rest->rest_start)->format('H:i') }}</div>
            </div>
            <div class="form-group">
                <label for="rest_end_{{ $index }}">休憩{{ $index + 1 }}終了時間</label>
                <div class="form-control-plaintext">{{ \Carbon\Carbon::parse($rest->rest_end)->format('H:i') }}</div>
            </div>
        @endforeach
        <div class="form-group">
            <label for="note">備考</label>
            <div class="form-control-plaintext">{{ $correct->note }}</div>
        </div>
        <button type="submit" class="btn btn-primary">承認</button>
    </form>
@endsection
