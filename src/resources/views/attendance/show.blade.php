<?php
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <h1 class="title">勤怠詳細</h1>
    <p>日付: {{ $attendance->date }}</p>
    <p>出勤時間: {{ $attendance->clock_in }}</p>
    <p>退勤時間: {{ $attendance->clock_out }}</p>
@endsection
