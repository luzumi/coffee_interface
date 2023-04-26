@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="grid_container">

            <div class="title_app">
                <h1>Get me Coffee</h1>
            </div>

            <div class="title_welcome" id="csrf">
                <h2>Herzlich willkommen</h2>
            </div>

            <div class="title_text">
                <h2>
                    {{-- Link für Entwicklung, ersetzt das Auflegen einer RFID-Karte --}}
                     <a href="{{ route('setId') }}">
                     Bitte halten Sie Ihren RFID-Chip an den Leser.
                     </a>

                    Bitte halten Sie Ihren RFID-Chip an den Leser.

                </h2>
                <div class="clock-container">
                    <div class="clock" id="clock">
                        <div class="hour-hand"></div>
                        <div class="minute-hand"></div>
                        <div class="second-hand"></div>
                    </div>
                    <div class="digital-clock" id="digital-clock"></div>
                </div>
            </div>

            <div class="item"></div>

        </div>
    </div>
    <div class="loader"></div>
@endsection

@section('scripts')
    {{--    CLOCK   --}}
    <script src="{{ asset('js/clock.js') }}"></script>
    {{--    Load    --}}
    <script src="{{ asset('js/menu_load.js') }}"></script>

@endsection
