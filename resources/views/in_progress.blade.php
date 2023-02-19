@extends('menu')

@section('progress')
    <div class="progress-section">
        <h1>bitte warten</h1>
        <p id="demo"></p>
        <div class="loader">0</div>
    </div>
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
                if (userId > 0) {
                    console.log('waiting..')
                    // Wiederhole den Request, wenn kein Benutzer gefunden wurde
                    xhr.open("GET", "{{ route('webhook_data') }}");
                    xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");
                    xhr.send();
                } else {
                    console.log('Benutzer reset')
                    xhr.open("GET", "{{ route('home') }}");
                    xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");

                    xhr.send();
                    window.location.href = '/';

                }
            }
        };
        xhr.send();

    </script>


@endsection
