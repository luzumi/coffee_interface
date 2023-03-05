@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="grid_container">

            <div class="title_app">
                <h1>Get me Coffee</h1>
            </div>

            <div class="title_welcome">
                <h2>Herzlich Willkommen</h2>
            </div>

            <div class="title_text">
                <h2>
                    <a href="{{ route('setId') }}">
                        Bitte halten Sie Ihren RFID Chip an den Leser.
                    </a>
                </h2>
                <div class="clock" id="clock">
                    <div class="hour-hand"></div>
                    <div class="minute-hand"></div>
                    <div class="second-hand"></div>
                </div>
            </div>
            <div class="item"></div>
        </div>
    </div>

@endsection

@section('scripts')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet"/>
    <script>
        function setClock() {
            const date = new Date();
            const hours = date.getHours();
            const minutes = date.getMinutes();
            const seconds = date.getSeconds();

            const hourDeg = (hours / 12) * 360 + (minutes / 60) * 30;
            const minuteDeg = (minutes / 60) * 360 + (seconds / 60) * 6;
            const secondDeg = (seconds / 60) * 360 - 90;

            const hourHand = document.querySelector(".hour-hand");
            const minuteHand = document.querySelector(".minute-hand");
            const secondHand = document.querySelector(".second-hand");

            hourHand.style.transform = `rotate(${hourDeg}deg)`;
            minuteHand.style.transform = `rotate(${minuteDeg}deg)`;
            secondHand.style.transform = `rotate(${secondDeg}deg)`;

        }

        setInterval(setClock, 1000); // update the clock every second
    </script>
    <script>
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
                    // Wiederhole den Request, wenn kein Benutzer gefunden wurde
                    xhr.open("GET", "{{ route('webhook_data') }}");
                    xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");
                    xhr.send();
                } else {
                    console.log('Benutzer gefunden' + userId)
                    xhr.open("GET", "{{ route('menu') }}");
                    xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");

                    xhr.send();
                    window.location.href = '/menu';

                }
            }
        };
        xhr.send();

    </script>

@endsection
