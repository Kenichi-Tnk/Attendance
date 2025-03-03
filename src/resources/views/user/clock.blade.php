<!DOCTYPE html>
<html>
<head>
    <title>勤怠打刻</title>
</head>
<body>
    <h1>勤怠打刻</h1>
    <form action="{{ route('user.clock_in') }}" method="POST">
        @csrf
        <button type="submit">出勤</button>
    </form>
    @if(isset($attendance))
    <form action="{{ route('user.clock_out', ['id' => $attendance->id]) }}" method="POST">
        @csrf
        <button type="submit">退勤</button>
    </form>
    @endif
</body>
</html>