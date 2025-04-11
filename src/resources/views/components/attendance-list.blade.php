<div class="attendance-list">
    <h1 class="title">| {{ $title}}</h1>

    <div class="pagination">
        <a href="{{ $previousLink }}" class="pagination__link pagination__link--prev">前月</a>
        <span class="pagination__current">{{ $currentMonth }}</span>
        <a href="{{ $nextLink }}" class="pagination__link pagination__link--next">翌月</a>
    </div>

    @foreach ($attendances as $attendance)
        <div class="attendance-row">
            <span>{{ \Carbon\Carbon::parse($attendance->date)->format('n月j日') }}({{ ['日', '月', '火', '水', '木', '金', '土'][\Carbon\Carbon::parse($attendance->date)->dayOfWeek] }})</span>
            <span>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }}</span>
            <span>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}</span>
            <span>{{ $attendance->rest_time }}</span>
            <span>{{ $attendance->total_time }}</span>
            <span>
                <a href="{{ route('attendance.show', $attendance->id) }}">詳細</a>
            </span>
        </div>
    @endforeach

    @if ($isAdmin)
        <a href="{{ $csvLink }}" class="btn btn-primary">CSV出力</a>
    @endif
</div>
