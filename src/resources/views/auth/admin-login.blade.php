@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <h1 class="title">管理者ログイン</h1>
    <form class="form-content" action="{{ route('admin.login') }}" method="POST">
        @csrf
        <label class="form-content__label" for="email">メールアドレス
            <input class="form-content__input" type="email" name="email" value="{{ old('email') }}">
        </label>
        @error('email')
            <div class="form-content__error">{{ $message }}</div>
        @enderror

        <label class="form-content__label" for="password">パスワード
            <input class="form-content__input" type="password" name="password">
        </label>
        @error('password')
            <div class="form-content__error">{{ $message }}</div>
        @enderror
        <div class="form-content__button">
            <button class="form-content__button-submit" type="submit">管理者ログイン</button>
        </div>
    </form>
@endsection
