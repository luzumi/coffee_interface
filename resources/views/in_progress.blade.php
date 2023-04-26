@extends('menu')

@section('progress')
    <div class="overlay"></div>
    <input type="hidden" id="user_role" value="{{ $viewData['role'] }}">

    <div class="progress-section">
        <img class="waiting-icon" src="{{ asset('storage/media/waitingIcon.svg') }}" alt="Dein SVG-Bild"/>

        <div class="svg-container">
            <svg class="overlay-svg" viewBox="0 0 900 1000" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <clipPath id="clip-path">
                        <rect id="clip-rect" x="10" y="100%" width="100%" height="0%"></rect>
                    </clipPath>
                </defs>
                <path id="green-path" class="green-path" clip-path="url(#clip-path)"
                      d="m 345.14264,667.58171 c -16.17022,-65.10339 -12.4962,-108.59404 -12.30068,-176.1016 -0.44286,-74.15435 1.22351,-135.38835 0.66927,-209.54243 13.37531,6.68804 35.14589,3.74348 53.59173,5.0091 57.42923,1.49072 325.51842,11.28704 326.50643,-14.44447 -1.13408,21.54217 -0.47775,326.56981 -1.40995,398.0161 C 701.67883,730.69012 645.5859,792.28232 519.68328,791.67196 426.29319,790.45073 365.95411,742.40631 345.14264,667.58171 Z"></path>
            </svg>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        setTimeout(() => {
            window.location.href = '/';
        }, 55000);
    </script>

    <script>
        window.onload = function () {
            const clipRect = document.getElementById('clip-rect');
            const duration = 50000; // Dauer der Animation in Millisekunden

            function updateHeight() {
                const elapsedTime = Date.now() - startTime;
                const progress = elapsedTime / duration;

                clipRect.setAttribute('y', 100 - progress * 100 + '%');
                clipRect.setAttribute('height', progress * 100 + '%');

                if (progress < 1) {
                    requestAnimationFrame(updateHeight);
                }
            }

            const startTime = Date.now();
            updateHeight();
        };
    </script>
@endsection
