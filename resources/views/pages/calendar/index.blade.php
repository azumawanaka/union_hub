@extends('layouts.calendar')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4>Calendar</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box m-b-50">
                                <div id="calendar"></div>
                            </div>
                        </div>

                        @include('pages.calendar.modals.join-event')
                    </div>
                </div>
            </div>
            <!-- /# card -->
        </div>
    </div>

@endsection
