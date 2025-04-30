@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1>| スタッフ一覧</h1>

    <div class="staff-header">
        <span>名前</span>
        <span>メールアドレス</span>
        <span>詳細</span>
    </div>

    @foreach($users as $user)
        <div class="staff-row">
            <span>{{ $user->name }}</span>
            <span>{{ $user->email }}</span>
            <span>
                <a href="{{ route('admin.staff.show', $user->id) }}">詳細</a>
            </span>
        </div>
    @endforeach
@endsection
