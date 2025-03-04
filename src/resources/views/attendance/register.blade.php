@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <h1 class="title">勤怠登録</h1>
    <p>ステータス: {{ $attendance ? $attendance->status : '出勤外' }}</p>
    <p>日付: {{ now()->toDateString() }}</p>
    <p>現在の時間: {{ now()->format('H:i') }}</p>

    @if (!$attendance || $attendance->status == 'not_started')
        <form action="{{ route('attendance.store') }}" method="POST" class="form-content">
            @csrf
            <input type="hidden" name="status" value="working">
            <div class="form-content__button">
                <button class="form-content__button-submit" type="submit">出勤</button>
            </div>
        </form>
    @elseif ($attendance->status == 'working')
        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="form-content">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="on_break">
            <div class="form-content__button">
                <button class="form-content__button-submit" type="submit">休憩入</button>
            </div>
        </form>
        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="form-content">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="finished">
            <div class="form-content__button">
                <button class="form-content__button-submit" type="submit">退勤</button>
            </div>
        </form>
    @elseif ($attendance->status == 'on_break')
        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="form-content">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="working">
            <div class="form-content__button">
                <button class="form-content__button-submit" type="submit">休憩戻</button>
            </div>
        </form>
    @elseif ($attendance->status == 'finished')
        <p>お疲れ様でした</p>
    @endif
@endsection
