@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <h1 class="title">会員登録</h1>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label class="form-content__label" for="name">名前
            <input class="form-content__input" type="text" id="name" name="name" value="{{ old('name') }}">
        </label>
        @error('name')
            <div class="form-content__error">{{ $message }}</div>
        @enderror

        <label class="form-content__label" for="email">メールアドレス
            <input class="form-content__input" type="email" id="email" name="email" value="{{ old('email') }}">
        </label>
        @error('email')
            <div class="form-content__error">{{ $message }}</div>
        @enderror

        <label class="form-content__label" for="password">パスワード
            <input class="form-content__input" type="password" id="password" name="password">
        </label>
        @error('password')
            <div class="form-content__error">{{ $message }}</div>
        @enderror

        <label class="form-content__label" for="password_confirmation">パスワード確認
            <input class="form-content__input" type="password" id="password_confirmation" name="password_confirmation">
        </label>

        <div class="form-content__button">
            <button class="form-content__button-submit" type="submit">登録</button>
        </div>
    </form>
    <p class="transition-text">既にアカウントをお持ちですか？</p>
    <a class="transition-link" href="/login">ログインはこちら</a>
@endsection
