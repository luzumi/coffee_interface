@extends('layouts.app')

@section('content')
    <h1>WaitingScreen</h1>

    <div class="loader"></div>
    <a href="{{ route('setId') }}">
        <div class="loader"></div>
    </a>


@endsection

@section('scripts')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet"/>

    <script>
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "{{ route('webhook_data') }}");
        xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");
        xhr.onreadystatechange = function() {
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
