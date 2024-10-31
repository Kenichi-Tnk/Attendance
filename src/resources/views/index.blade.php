@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
  @if (session('message'))
    <div class="attendance__alert--success">
        {{ session('message') }} // sessionに格納されたメッセージを表示
    </div>
    @endif
</div>

<div class="attendance__content">
  <div class="attendance__panel">
    @if (!$my_attendance)
    <form class="attendance__button" action="/attendances/start" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit">勤務開始</button>
    </form>
    @elseif (!$my_attendance['attendance_out'])
    <form class="attendance__button" action="/attendances/end" method="post">
      @csrf
      <input type="hidden" name="attendance_id" value="{{ $my_attendance['id'] }}">
      <button class="attendance__button-submit" type="submit">勤務終了</button>
    </form>
    @endif
  </div>
  <div class="attendance-table">
    <table class="attendance-table__inner">
      <tr class="attendance-table__row">
        <th class="attendance-table__header">名前</th>
        <th class="attendance-table__header">開始時間</th>
        <th class="attendance-table__header">終了時間</th>
      </tr>

      @foreach ($all_attendances as $attendance)
      <tr class="attendance-table__row">
        <td class="attendance-table__item">{{ $attendance['user']['name'] }}</td>
        <td class="attendance-table__item">{{ $attendance['attendance_in'] }}</td>
        <td class="attendance-table__item">{{ $attendance['attendance_out'] }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endsection
