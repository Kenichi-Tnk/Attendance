@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage__alert">
    @if (session('message'))
    <div class="mypage__alert--success">
        {{ session('message') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="mypage__alert--danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<div class="mypage__content">
    <div class="mypage__title">
        <h2>{{ $user['name'] }}さんの勤怠</h2>
    </div>
    <form class="create-form" action="/attendances" method="post">
        @csrf
        <div class="create-form__item">
            <input class="create-form__item-input" type="date" name="date" value="2022-01-01">
            <input class="create-form__item-input" type="time" name="attendance_in" value="09:00:00" step="1">
            <input class="create-form__item-input" type="time" name="attendance_out" value="18:00:00" step="1">
        </div>
        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
    </form>

</div>
<div class="mypage-table">
    <table class="mypage-table__inner">
        <tr class="mypage-table__row">
            <th class="mypage-table__header">
                <span class="mypage-table__header-span">日付</span>
                <span class="mypage-table__header-span">開始時間</span>
                <span class="mypage-table__header-span">終了時間</span>
            </th>
        </tr>
        @foreach ($user->attendances as $attendance)
        <tr class="mypage-table__row">
            <td class="mypage-table__item">
                <form class="update-form" action="/attendances/{{ $attendance['id'] }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="update-form__item">
                        <input class="update-form__item-input" type="date" name="date" value="{{ $attendance['date'] }}">
                    </div>
                    <div class="update-form__item">
                        <input class="update-form__item-input" type="time" name="attendance_in" value="{{ $attendance['attendance_in'] }}" step="1">
                    </div>
                    <div class="update-form__item">
                        <input class="update-form__item-input" type="time" name="attendance_out" value="{{ $attendance['attendance_out'] }}" step="1">
                    </div>
                    <div class="update-form__button">
                        <button class="update-form__button-submit" type="submit">更新</button>
                    </div>
                </form>
            </td>
            <td class="mypage-table__item">
                <form class="delete-form" action="/attendances/{{ $attendance['id'] }}" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="delete-form__button">
                        <button class="delete-form__button-submit" type="submit">削除</button>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
</div>
@endsection