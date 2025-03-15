@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1>勤怠詳細</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">日付</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $attendance->date }}" required>
        </div>
        <div class="form-group">
            <label for="clock_in">出勤時間</label>
            <input type="time" class="form-control" id="clock_in" name="clock_in" value="{{ $attendance->clock_in }}" required>
        </div>
        <div class="form-group">
            <label for="clock_out">退勤時間</label>
            <input type="time" class="form-control" id="clock_out" name="clock_out" value="{{ $attendance->clock_out }}" required>
        </div>
        <div class="form-group">
            <label for="rest_start">休憩開始時間</label>
            <input type="time" class="form-control" id="rest_start" name="rest_start" value="{{ $attendance->rest_start }}">
        </div>
        <div class="form-group">
            <label for="rest_end">休憩終了時間</label>
            <input type="time" class="form-control" id="rest_end" name="rest_end" value="{{ $attendance->rest_end }}">
        </div>
        <div class="form-group">
            <label for="note">備考</label>
            <textarea class="form-control" id="note" name="note" required>{{ $attendance->note }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">修正</button>
    </form>
@endsection
