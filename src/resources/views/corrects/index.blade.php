@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/requests.css') }}">
@endsection

@section('content')
    <h1 class="title">申請一覧</h1>
    <table class="requests-table">
        <thead>
            <tr>
                <th>日付</th>
                <th>申請内容</th>
                <th>ステータス</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->date }}</td>
                    <td>{{ $request->content }}</td>
                    <td>{{ $request->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
