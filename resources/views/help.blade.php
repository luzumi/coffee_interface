@extends('layouts.app')

@section('content')
    {{--    <div class="overlay"></div>--}}
    <div class="title_app">
        <h1>Get me Coffee - </h1>

        <h1 class="title_welcome"> &nbsp;Help</h1>
    </div>

    <div class="flex-help">
        <a href="{{ route('help_rfid') }}" class="help-button">
            <div class="button-bg-rfid-help"><p class="title_text">RFID</p></div>
        </a>

        <a href="{{ route('help_menu') }}" class="help-button">
            <div class="button-bg-menu-help"><p class="title_text">MENU</p></div>
        </a>
    </div>
    <div class="menu-logout">
        <form method="GET" action="{{ route('home') }}">

            <button type="submit" class="btn menu-logout-button">Zurück</button>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        setTimeout(() => {
            window.location.href = '/';
        }, 200000);
    </script>
@endsection
