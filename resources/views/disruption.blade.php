@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="grid_container">

            <div class="title_app">
                <h1>Get me Coffee</h1>
                <div class="title_welcome" id="csrf">
                    <h2>Herzlich willkommen</h2>
                </div>
            </div>


            {{--            <div class="title_text">--}}
            <div class="disruption-border">
                <h2><b class="disruption">STÖRUNG!!</b></h2>
            </div>
            <div class="disruption_text">
                <h2> Eine Zubereitung ist derzeit nicht möglich!</h2>
                <h3> Der Eingriff eines Servicetechnikers ist notwendig. </h3>
                <h3> Informieren Sie den Administrator! </h3>
            </div>
            {{--            <div class="clock-container">--}}
            {{--                <div class="clock" id="clock">--}}
            {{--                    <div class="hour-hand"></div>--}}
            {{--                    <div class="minute-hand"></div>--}}
            {{--                    <div class="second-hand"></div>--}}
            {{--                </div>--}}
            {{--                <div class="digital-clock" id="digital-clock"></div>--}}
            {{--            </div>--}}
        </div>

        <div class="item"></div>

    </div>
    <div class="loader"></div>
@endsection
@section('scripts')
    <script>
        {{--setTimeout(function () {--}}
        {{--    window.location.href = "{{ route('logout') }}";--}}
        {{--}, 12000);--}}
    </script>

    <script src="{{ asset('js/clock.js') }}"></script>
@endsection
