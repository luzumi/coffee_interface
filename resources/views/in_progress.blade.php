@extends('menu')

@section('progress')
    <div class="overlay"></div>
    <input type="hidden" id="user_role" value="{{ $viewData['role'] }}">

    <div class="progress-section">
        <svg viewBox="0 0 200 200">
            <!-- Kaffeetasse -->
            <path fill="#D3A06F"
                  d="M149.3 157.9h-98.6c-6.8 0-12.4-5.6-12.4-12.4v-94.9c0-6.8 5.6-12.4 12.4-12.4h98.6c6.8 0 12.4 5.6 12.4 12.4v94.9c0 6.8-5.6 12.4-12.4 12.4z"/>
            <path fill="#B37247"
                  d="M149.3 57.9h-98.6c-6.8 0-12.4 5.6-12.4 12.4v94.9c0 6.8 5.6 12.4 12.4 12.4h98.6c6.8 0 12.4-5.6 12.4-12.4v-94.9c0-6.8-5.6-12.4-12.4-12.4z"/>

            <!-- Kaffee -->
            <rect x="46.8" y="79.3" fill="#40230D" width="106.3" height="0">
                <animate attributeName="height" from="0" to="94.9" dur="5s" fill="freeze"/>
            </rect>

            <!-- Henkel -->
            <path fill="#D3A06F" d="M146.1 68.6h-16.2v89.1c0 2.2 1.8 4 4 4h8.1c2.2 0 4-1.8 4-4V72.6c0-2.2-1.8-4-4-4z"/>
            <path fill="#B37247" d="M142.2 68.6H60.3v4.4c0 3.7 3 6.7 6.7 6.7h68.5c3.7 0 6.7-3 6.7-6.7v-4.4z"/>
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
