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
            <input type="date" class="form-control" id="date" name="date" value="{{ $correct->date }}" readonly>
        </div>
        <div class="form-group">
            <label for="clock_in">出勤時間</label>
            <input type="time" class="form-control" id="clock_in" name="clock_in" value="{{ $correct->clock_in }}" readonly>
        </div>
        <div class="form-group">
            <label for="clock_out">退勤時間</label>
            <input type="time" class="form-control" id="clock_out" name="clock_out" value="{{ $correct->clock_out }}" readonly>
        </div>
        <div class="form-group">
            <label for="rest_start">休憩開始時間</label>
            <input type="time" class="form-control" id="rest_start" name="rest_start" value="{{ $correct->rest_start }}" readonly>
        </div>
        <div class="form-group">
            <label for="rest_end">休憩終了時間</label>
            <input type="time" class="form-control" id="rest_end" name="rest_end" value="{{ $correct->rest_end }}" readonly>
        </div>
        <div class="form-group">
            <label for="note">備考</label>
            <textarea class="form-control" id="note" name="note" readonly>{{ $correct->note }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">承認</button>
    </form>
@endsection
