<!DOCTYPE html>
<html>
<head>
    <title>勤怠一覧</title>
</head>
<body>
    <h1>勤怠一覧</h1>
    <ul>
        @foreach ($attendances as $attendance)
            <li>
                日付: {{ $attendance->date }}<br>
                出勤時間: {{ $attendance->clock_in }}<br>
                退勤時間: {{ $attendance->clock_out }}<br>
                状態: {{ $attendance->status }}<br>
                <a href="{{ route('user.attendance_detail', $attendance->id) }}">詳細</a>
            </li>
        @endforeach
    </ul>
</body>
</html>