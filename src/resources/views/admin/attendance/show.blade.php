@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')
    <!-- 共通コンポーネントを使用 -->
    <x-attendance-detail :attendance="$attendance" :action="route('admin.attendance.update', $attendance->id)" :isAdmin="true" />
@endsection
