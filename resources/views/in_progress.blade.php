@extends('menu')

@section('progress')
    {{--    <div class="progress-section">--}}
    {{--        <a href="{{ route('setId') }}">--}}
    {{--            <div class="progress"></div>--}}
    {{--        </a>--}}
    {{--    </div>--}}
    <div class="coffee-cup">
        <svg viewBox="0 0 100 100">
            <path fill="#A06128" d="M30,70 L30,20 Q30,10 40,10 L60,10 Q70,10 70,20 L70,70 Z"/>
            <path fill="#8B4513"
                  d="M25,75 L75,75 Q80,75 80,80 L80,90 Q80,100 75,100 L25,100 Q20,100 20,90 L20,80 Q20,75 25,75 Z"/>
            <rect x="30" y="70" width="40" height="0" fill="#3E1E03">
                <animate attributeName="height" from="0" to="50" dur="5s" fill="freeze"/>
            </rect>
        </svg>
    </div>

@endsection


@section('scripts')
    <script>
        setTimeout(function() {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "{{ route('webhook_data') }}");
            xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    let responseText = xhr.responseText;
                    if (responseText.startsWith("data")) {
                        responseText = responseText.substring(5);
                    }

                    let data = JSON.parse(responseText);
                    const userId = data.data;
                    if (userId > 0) {
                        // Wiederhole den Request, wenn kein Benutzer gefunden wurde
                        setTimeout(function() {
                            xhr.open("GET", "{{ route('webhook_data') }}");
                            xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");
                            xhr.send();
                        }, 5000);
                    } else {
                        xhr.open("GET", "{{ route('home') }}");
                        xhr.setRequestHeader("x-requested-with", "XMLHttpRequest");
                        xhr.send();
                        window.location.href = '/';
                    }
                }
            };
            xhr.send();
        }, 5000);
    </script>
@endsection
