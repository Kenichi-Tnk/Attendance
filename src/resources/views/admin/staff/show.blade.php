@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
    <x-attendance-list 
        title="{{ $user->name }}さんの勤怠"
        :attendances="$attendances" 
        :currentMonth="\Carbon\Carbon::parse($month)->format('Y/m')" 
        :previousLink="route('admin.staff.show', ['id' => $user->id, 'month' => \Carbon\Carbon::parse($month)->subMonth()->format('Y-m')])" 
        :nextLink="route('admin.staff.show', ['id' => $user->id, 'month' => \Carbon\Carbon::parse($month)->addMonth()->format('Y-m')])" 
        :isAdmin="true" 
        :csvLink="route('admin.staff.csv', ['id' => $user->id, 'month' => $month])" 
    />
@endsection