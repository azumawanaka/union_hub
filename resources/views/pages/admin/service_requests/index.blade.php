@extends('layouts.service')

@section('content')
    @if(auth()->user()->role === 1)
        @include('pages.admin.service_requests.tables.lists')
    @else
        @include('pages.admin.service_requests.lists.index', [
            'title' => 'Availed Services',
            'data' => $services,
        ])
    @endif

@endsection
