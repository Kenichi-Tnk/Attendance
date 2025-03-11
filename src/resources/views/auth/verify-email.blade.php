@extends('layouts.app')

@section('css')
    <link rel=stylesheet href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
    <h1 class="title">メールアドレス確認</h1>
    <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
    <p>メール認証を完了してください。</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証はこちらから</button>
    </form>
    <p>
        <a href="#" onclick="event.preventDefault(); document.getElementById('resend-verification-form').submit();">認証メールを再送する
        </a>
    </p>
    <form id="resend-verification-form" method="POST" action="{{ route('verification.send') }}" style="display: none;">
        @csrf
    </form>
@endsection
