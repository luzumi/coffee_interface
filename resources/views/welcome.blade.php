@extends('layouts.app')

@section('content')
    <h1>WEBHOOK Test</h1>
    <p id="demo"></p>
    <form method="POST" action="{{ route('turn_on') }}">
        @csrf
        <button type="submit">Relais einschalten</button>
    </form>
@endsection

@section('scripts')
    <script>
        {{--const checkWebhook = async () => {--}}
        {{--    //überprüfe den ersten eintrag in der db rasp_users auf die user_id--}}
        {{--    const response = await fetch("{{ route('webhook_data') }}");--}}
        {{--    //if response is null, the webhook was not received--}}
        {{--    const data = await response.json();--}}

        {{--    if (data.user_id < 1 || data.user_id == null)--}}
        {{--    {--}}
        {{--        console.log('Webhook nicht empfangen');--}}
        {{--        return null;--}}
        {{--    }--}}
        {{--    {--}}
        {{--        console.log('Webhook empfangen' + data.user_id);--}}
        {{--        window.location.href = "{{ route('menu') }}";--}}
        {{--    }--}}
        {{--};--}}

        {{--setInterval(checkWebhook, 2000);--}}
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
                const userId = data.data.user_id

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
