@extends('layouts.app')


@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')
    <div class="attendance-detail">
        <div class="attendance-header">
            <h1 class="title"> | 勤怠詳細</h1>
        </div>

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
            <div class="attendance-block">
                <div class="attendance-label">名前</div>
                <div class="attendance-value">{{ $attendance->user->name }}</div>
            </div>
            <hr class="divider">
            <div class="attendance-block">
                <div class="attendance-label">日付</div>
                <div class="attendance-value">
                    <span>{{ \Carbon\Carbon::parse($attendance->date)->format('Y年') }}</span>
                    <span style="margin-left: 31%;">{{ \Carbon\Carbon::parse($attendance->date)->format('m月d日') }}</span>
                </div>
            </div>
            <hr class="divider">
            <div class="attendance-block">
                <label class="attendance-label">出勤・退勤</label>
                <div class="attendance-value">
                    <input type="time" class="form-control" id="clock_in" name="clock_in" value="{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}" {{ $attendance->isPendingApproval() ? 'disabled' : '' }}>
                    <span class="mx-2">〜</span>
                    <input type="time" class="form-control" id="clock_out" name="clock_out" value="{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}" {{ $attendance->isPendingApproval() ? 'disabled' : '' }}>
                </div>
            </div>
            <hr class="divider">
            @forelse ($attendance->rests as $index => $rest)
                <div class="attendance-block">
                    <div class="attendance-label">{{ $index === 0 ? '休憩' : '休憩' . $index }}</div>
                    <div class="attendance-value">
                        <input type="time" class="form-control" id="rest_start_{{ $index }}" name="rests[{{ $index }}][rest_start]" value="{{ $rest->rest_start ? \Carbon\Carbon::parse($rest->rest_start)->format('H:i') : '' }}" {{ $attendance->isPendingApproval() ? 'disabled' : '' }}>
                        <span class="mx-2">〜</span>
                        <input type="time" class="form-control" id="rest_end_{{ $index }}" name="rests[{{ $index }}][rest_end]" value="{{ $rest->rest_end ? \Carbon\Carbon::parse($rest->rest_end)->format('H:i') : '' }}" {{ $attendance->isPendingApproval() ? 'disabled' : '' }}>
                    </div>
                </div>
                <hr class="divider">
            @empty
                <div class="attendance-block">
                        <div class="attendance-label">休憩</div>
                        <div class="attendance-value">
                            <input type="time" class="form-control" id="rest_start_0" name="rests[0][rest_start]" value="00:00">
                            <span class="mx-2">〜</span>
                            <input type="time" class="form-control" id="rest_end_0" name="rests[0][rest_end]" value="00:00">
                        </div>
                    </div>
            @endforelse
            <hr class="divider">
            <div class="attendance-block">
                <label class="attendance-label">備考</label>
                <div class="attendance-value">
                    @if ($attendance->isPendingApproval())
                        <div class="form-control-plaintext">{{ $attendance->note }}</div>
                    @else
                        <textarea class="form-control" id="note" name="note">{{ old('note', $attendance->note) }}</textarea>
                    @endif
                </div>
            </div>
            <div class="form-actions">
                @if ($attendance->isPendingApproval())
                    <p class="text-danger">*承認待ちのため修正はできません。</p>
                @else
                    <button type="submit" class="btn btn-primary">修正</button>
                @endif
            </div>
        </form>
    </div>
@endsection
