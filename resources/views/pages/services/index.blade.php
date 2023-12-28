@extends('layouts.service')

@section('content')

    @if(auth()->user()->role === 1)
        @include('pages.services.tables.lists')
    @else
        <h4 class="card-title mb-4">Services</h4>
        @include('pages.services.cards.lists')
    @endif

@endsection
