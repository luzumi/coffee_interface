@extends('admin.admin')

@section('dashboard')
    {{--    <div class="admin-dash-user-table">--}}
    {{--        <table class="admin-table">--}}
    {{--            <tr>--}}
    {{--                <th>ID</th>--}}
    {{--                <th>Username</th>--}}
    {{--                <th>Vorname</th>--}}
    {{--                <th>Name</th>--}}
    {{--                <th>credits</th>--}}
    {{--                <th></th>--}}
    {{--                <!-- Fügen Sie hier zusätzliche Spalten für andere Benutzerinformationen hinzu -->--}}
    {{--            </tr>--}}

    {{--            @foreach ($viewData['user'] as $user)--}}
    {{--                <tr>--}}
    {{--                    <td>{{ $user->id }}</td>--}}
    {{--                    <td>{{ Str::limit($user->username, 10) }}</td>--}}
    {{--                    <td>{{ Str::limit($user->firstname, 10) }}</td>--}}
    {{--                    <td>{{ Str::limit($user->lastname, 10) }}</td>--}}
    {{--                    <td>{{ $user->credits }}</td>--}}
    {{--                    <td><a href="users/{{ $user->id }}/edit">Edit</a></td>--}}
    {{--                    <!-- Fügen Sie hier zusätzliche Zellen für andere Benutzerinformationen hinzu -->--}}
    {{--                </tr>--}}
    {{--            @endforeach--}}
    {{--        </table>--}}
    {{--    </div>--}}
    <div class="admin-dash-user-table">
        @livewire('user-table')
    </div>
@endsection

