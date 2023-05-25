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
                        <h2><a href="{{ route('admin') }}" class="admin-dash-btn">Übersicht</a></h2>
                    </div>
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

            @if(!Request::is('admin'))
                <div class="admin-dash-area">
                    @yield('dashboard')
                </div>
            @else
                <div class="admin-dash-area">
                    <div class="admin-dash-title"> BestOf</div>
                    <hr>
                    @foreach($viewData['bestOf'] as $user)
                        {{$user->username}}: {{ $user->coffee_orders_count }}<br>
                    @endforeach
                    <hr>
                    <hr>
                    <div class="admin-dash-title"> Neue Kartenanfragen </div>
                    <hr>
                    @foreach($viewData['newTags'] as $user)
                        {{$user->remarks}}: {{ $user->created_at }}<br>
                    @endforeach

                </div>
            @endif



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
