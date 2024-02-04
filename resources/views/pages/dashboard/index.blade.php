@extends('layouts.dashboard')

@section('content')

    @include('pages.dashboard.includes.cards')

    <div class="row">
        <div class="col-md-6">
            @include('pages.dashboard.includes.calendar')
        </div>

        <div class="col-md-6">
            @if (auth()->user()->role === 1)
                @include('pages.dashboard.includes.users')
            @else
                @include('pages.dashboard.includes.services')
            @endif
        </div>
    </div>

@endsection
