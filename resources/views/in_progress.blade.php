@extends('menu')

@section('progress')
    <div class="overlay"></div>
    <input type="hidden" id="user_role" value="{{ $viewData['role'] }}">

    <div class="progress-section">
        {{--        <svg viewBox="0 0 200 200">--}}
        {{--            <!-- Kaffeetasse -->--}}
        {{--            <path fill="#D3A06F"--}}
        {{--                  d="M149.3 157.9h-98.6c-6.8 0-12.4-5.6-12.4-12.4v-94.9c0-6.8 5.6-12.4 12.4-12.4h98.6c6.8 0 12.4 5.6 12.4 12.4v94.9c0 6.8-5.6 12.4-12.4 12.4z"/>--}}
        {{--            <path fill="#B37247"--}}
        {{--                  d="M149.3 57.9h-98.6c-6.8 0-12.4 5.6-12.4 12.4v94.9c0 6.8 5.6 12.4 12.4 12.4h98.6c6.8 0 12.4-5.6 12.4-12.4v-94.9c0-6.8-5.6-12.4-12.4-12.4z"/>--}}

        {{--            <!-- Kaffee -->--}}
        {{--            <rect x="46.8" y="79.3" fill="#40230D" width="106.3" height="0">--}}
        {{--                <animate attributeName="height" from="0" to="94.9" dur="5s" fill="freeze"/>--}}
        {{--            </rect>--}}

        {{--            <!-- Henkel -->--}}
        {{--            <path fill="#D3A06F" d="M146.1 68.6h-16.2v89.1c0 2.2 1.8 4 4 4h8.1c2.2 0 4-1.8 4-4V72.6c0-2.2-1.8-4-4-4z"/>--}}
        {{--            <path fill="#B37247" d="M142.2 68.6H60.3v4.4c0 3.7 3 6.7 6.7 6.7h68.5c3.7 0 6.7-3 6.7-6.7v-4.4z"/>--}}
        {{--        </svg>--}}
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="113.469" height="150"
             viewBox="0 0 30.059 39.725">
            <style>
                @keyframes fillAnimation {
                    0% {
                        transform: translateY(100%);
                    }
                    100% {
                        transform: translateY(0%);
                    }
                }

                #inhalt {
                    animation: fillAnimation 5s linear infinite;
                }
            </style>
            <defs>
                <clipPath id="tassenClip">
                    <path d="M11.237,19.018c0.182-1.835,1.038-5.526,5.205-5.526c4.167,0,5.022,3.691,5.204,5.526c0.171,1.727,0.286,3.676,0.286,4.982
                        c0,3.551-1.61,6.104-4.666,6.104c-3.057,0-4.723-2.553-4.723-6.104C10.951,22.694,11.066,20.746,11.237,19.018z"/>
                </clipPath>
            </defs>
            <g id="tasse">
                <path d="M29.808,20.117c-0.065-0.85-0.562-1.45-1.374-1.45h-0.744c-0.394,0-0.714,0.32-0.714,0.714s0.32,0.714,0.714,0.714h0.744
                    c0.238,0,0.331,0.197,0.331,0.307c-0.002,0.111-0.094,0.307-0.331,0.307h-1.378c-0.394,0-0.714,0.32-0.714,0.714
                    c0,0.394,0.32,0.714,0.714,0.714h1.378c0.812,0,1.309-0.6,1.374-1.45c0.411-5.295-2.66-9.619-7.953-9.619
                    c-5.293,0-8.364,4.324-7.953,9.619c0.065,0.85,0.562,1.45,1.374,1.45h1.379c0.394,0,0.714-0.32,0.714-0.714
                    c0-0.394-0.32-0.714-0.714-0.714h-1.379c-0.238,0-0.331-0.197-0.331-0.307c0-0.109,0.093-0.307,0.331-0.307h0.744
                    c0.394,0,0.714-0.32,0.714-0.714s-0.32-0.714-0.714-0.714h-0.744c-0.812,0-1.309,0.6-1.374,1.45c-0.411,5.295,2.66,9.619,7.953,9.619
                    c5.293,0,8.364-4.324,7.953-9.619z M19.981,22.003c0-3.551,1.666-6.104,4.723-6.104s4.666,2.553,4.666,6.104s-1.666,6.104-4.723,6.104
                    S19.981,25.555,19.981,22.003z"/>
                <path d="M5.5,25.289c-1.933,0-3.5,1.568-3.5,3.5v2c0,1.933,1.567,3.5,3.5,3.5h19c1.933,0,3.5-1.567,3.5-3.5v-2c0-1.932-1.567-3.5-3.5-3.5
                    H5.5z"/>
            </g>

            <g id="inhalt" clip-path="url(#tassenClip)">
                <rect x="10" y="12" width="10" height="15" fill="brown">
                    <animate attributeName="y" from="27" to="12" dur="5s" repeatCount="indefinite"/>
                </rect>
            </g>
        </svg>

    </div>
@endsection


@section('scripts')
    <script>
        setTimeout(() => {
            const userRole = document.getElementById('user_role').value;

            if (userRole === 'maintenance') {
                window.location.href = '/';
            } else {
                console.log('Benutzer reset');
                window.location.href = '/set';
            }

        }, 8000);
    </script>
@endsection
