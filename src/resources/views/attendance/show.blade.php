@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <h1 class="title">勤怠詳細</h1>
    <p>名前: {{ $attendance->user->name }}</p>
    <p>日付: {{ $attendance->date }}</p>
    <p>出勤時間: {{ $attendance->clock_in }}</p>
    <p>退勤時間: {{ $attendance->clock_out }}</p>
    @foreach ($attendance->rests as $index => $rest)
        <p>休憩{{ $index + 1 }}: {{ $rest->rest_start }} ~ {{ $rest->rest_end }}</p>
    @endforeach
    <p>備考: {{ $attendance->remarks }}</p>
@endsection
