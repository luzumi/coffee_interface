@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="admin-board">

            <div class="admin-title_app">
                <h1>Get me Coffee</h1>
            </div>

            <div class="admin-title_welcome" id="csrf">
                <h2>Administration</h2>
            </div>

            <div class="admin-dash">
                <h1 class="admin-dash-head">Admin-Dashboard</h1>

                <div class="admin-dash">
                    <hr>
                    <div class="admin-link">
                        <h2><a href="{{ route('admin.manage-users') }}" class="admin-dash-btn">Manage Users</a></h2>
                    </div>
                    <hr>
                    <div class="admin-link">
                        <h2><a href="{{ route('admin.manage-rfids') }}" class="admin-dash-btn">Manage RFID-Tags</a></h2>
                    </div>
                    <hr>
                    <div class="admin-link">
                        <h2><a href="{{ route('admin.manage-cats') }}" class="admin-dash-btn">Manage Categories</a></h2>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="admin-dash-area">
                @yield('dashboard')
            </div>
        </div>
    </div>
    <div class="menu-logout">
        <form method="GET" action="{{ route('logout') }}">
            <button type="submit" class="btn menu-logout-button">Logout</button>
        </form>
    </div>
@endsection

@section('scripts')
    {{--    Load    --}}
    {{--    <script src="{{ asset('js/menu_load.js') }}"></script>--}}

@endsection
