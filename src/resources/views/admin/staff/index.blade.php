@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1>スタッフ一覧</h1>
    <table class="table">
        <thead>
            <tr>
                <th>氏名</th>
                <th>メールアドレス</th>
                <th>月次勤怠</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('admin.staff.show', $user->id) }}" class="btn btn-primary">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
