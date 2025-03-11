@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance-register.css') }}">
@endsection

@section('content')
    <div class="attendance-info">
        <p class="attendance-info__status">
            @if (!$attendance)
                勤務外
            @else
                @switch($attendance->status)
                    @case('not_started')
                        勤務外
                        @break
                    @case('working')
                        出勤中
                        @break
                    @case('on_break')
                        休憩中
                        @break
                    @case('finished')
                        退勤済
                        @break
                    @default
                        勤務外
                @endswitch
            @endif
        </p>
        <p class="attendance-info__date">{{ now()->format('Y年m月d日') }}（{{ ['日', '月', '火', '水', '木', '金', '土'][now()->dayOfWeek] }}) </p>
        <p class="attendance-info__time">{{ now()->format('H:i') }}</p>
    </div>

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
