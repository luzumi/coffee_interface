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
                    <a href="{{ route('setId') }}">
                        Bitte halten Sie Ihren RFID-Chip an den Leser.
                    </a>
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
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet"/>
{{--    CLOCK   --}}
    <script>
        function setClock() {
            const date = new Date();
            let hours = date.getHours();
            let minutes = date.getMinutes();
            let seconds = date.getSeconds();

            const hourDeg = (hours / 12) * 360 + (minutes / 60) * 30;
            const minuteDeg = (minutes / 60) * 360 + (seconds / 60) * 6;
            const secondDeg = (seconds / 60) * 360 - 90;

            const hourHand = document.querySelector(".hour-hand");
            const minuteHand = document.querySelector(".minute-hand");
            const secondHand = document.querySelector(".second-hand");

            hourHand.style.transform = `rotate(${hourDeg}deg)`;
            minuteHand.style.transform = `rotate(${minuteDeg}deg)`;
            secondHand.style.transform = `rotate(${secondDeg}deg)`;

            const digitalClock = document.querySelector(".digital-clock");
            seconds < 10 ? seconds = "0" + seconds : seconds;
            minutes < 10 ? minutes = "0" + minutes : minutes;
            hours < 10 ? hours = "0" + hours : hours;
            digitalClock.innerHTML = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(setClock, 1000); // update the clock every second
    </script>
{{--    Load    --}}
    <script>
        function load(){
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "{{ route('webhook_data') }}");
            xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    let responseText = xhr.responseText;
                    if (responseText.startsWith("data")) {
                        responseText = responseText.substring(5);
                        console.log("if " + responseText)
                    }

                    let data = JSON.parse(responseText);
                    const userId = data.data
                    console.log(userId)
                    if (userId == null || userId < 1) {
                        console.log('kein Benutzer gefunden')
                    } else {
                        console.log('Benutzer gefunden' + userId)
                        window.location.href = '/menu';
                    }
                }
            };
            xhr.send();
        }
        setInterval(load, 1000);
    </script>
@endsection
