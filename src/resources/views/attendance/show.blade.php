@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <h1 class="title">勤怠詳細</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('attendance.correct', $attendance->id) }}" method="POST" class="centered-form">
        @csrf
        <div class="form-group">
            <label for="name">名前</label>
            <div class="form-control-plaintext">{{ $attendance->user->name }}</div>
        </div>
        <div class="form-group">
            <label for="date">日付</label>
            <div class="form-control-plaintext">{{ \Carbon\Carbon::parse($attendance->date)->format('Y年 m月d日') }}</div>
        </div>
        <div class="form-group">
            <label for="clock_in">出勤・退勤</label>
            <div class="d-flex">
                <input type="time" class="form-control" id="clock_in" name="clock_in" value="{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}" required>
                <span class="mx-2">〜</span>
                <input type="time" class="form-control" id="clock_out" name="clock_out" value="{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}" required>
            </div>
        </div>
        <div class="form-group">
            @forelse ($attendance->rests as $index => $rest)
                <div class="d-flex">
                    <label for="rest_start">{{ $index === 0 ? '休憩' : '休憩' . $index }}</label>
                    <input type="time" class="form-control" id="rest_start_{{ $index }}" name="rests[{{ $index }}][rest_start]" value="{{ $rest->rest_start ? \Carbon\Carbon::parse($rest->rest_start)->format('H:i') : '' }}">
                    <span class="mx-2">〜</span>
                    <input type="time" class="form-control" id="rest_end_{{ $index }}" name="rests[{{ $index }}][rest_end]" value="{{ $rest->rest_end ? \Carbon\Carbon::parse($rest->rest_end)->format('H:i') : '' }}">
                </div>
            @empty
                <p>休憩データがありません</p>
            @endforelse
        </div>
        <div class="form-group">
            <label for="note">備考</label>
            <textarea class="form-control" id="note" name="note" required>{{ $attendance->note }}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">修正</button>
        </div>
    </form>
@endsection
