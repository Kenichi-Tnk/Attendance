@extends('layouts.app')

@section('css')
    <link rel=stylesheet href="{{ asset('css/auth.css') }}">
@endsection

@section
    <h1 class="title">メールアドレス確認</h1>
    <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
    <p>メール認証を完了してください。</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証はこちらから</button>
    </form>
@endsection
