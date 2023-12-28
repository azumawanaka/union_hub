@extends('layouts.service')

@section('content')

    @if(auth()->user()->role === 1)
        @include('pages.services.tables.lists')
    @else
        @include('pages.services.cards.lists')
    @endif

@endsection
