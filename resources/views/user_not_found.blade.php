@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="grid_container">

            <div class="title_app">
                <h1>Get me Coffee</h1>
            </div>

{{--            <div class="title_welcome" id="csrf">--}}
{{--                <h2>Herzlich willkommen</h2>--}}
{{--            </div>--}}

            <div class="title_text">
                <div>
                    <h2> <a href="#">Diese Karte ist im System noch nicht erfasst.</a> </h2>

                    <h3 class="user_not_found"> Bitte wenden Sie sich mit dem </h3>
                    <h3 class="user_not_found"> Code: <b> &nbsp;{{ substr($user->username, 9) }}&nbsp; </b> </h3>
                    <h3 class="user_not_found"> an den </h3>
                    <h3 class="user_not_found"> Administrator. </h3>
                </div>
{{--                <div class="clock-container">--}}
{{--                    <div class="clock" id="clock">--}}
{{--                        <div class="hour-hand"></div>--}}
{{--                        <div class="minute-hand"></div>--}}
{{--                        <div class="second-hand"></div>--}}
{{--                    </div>--}}
{{--                    <div class="digital-clock" id="digital-clock"></div>--}}
{{--                </div>--}}
            </div>

            <div class="item"></div>

        </div>
    </div>
    <div class="loader"></div>
@endsection
@section('scripts')
    <script>
        setTimeout(function () {
            window.location.href = "{{ route('logout') }}";
        }, 8000);
    </script>
    <script src="{{ asset('js/clock.js') }}"></script>
@endsection
