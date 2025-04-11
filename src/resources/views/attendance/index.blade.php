@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
    <x-attendance-list
        title="勤怠一覧"
        :attendances="$attendances"
        :currentMonth="$currentMonth"
        :previousLink="route('attendance.index', ['month' => $previousMonth])"
        :nextLink="route('attendance.index', ['month' => $nextMonth])"
        :isAdmin="false"
    />
@endsection
