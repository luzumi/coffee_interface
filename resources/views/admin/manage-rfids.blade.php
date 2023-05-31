@extends('admin.admin')

@section('dashboard')
    {{--    <div class="admin-dash-user-table">--}}
    {{--        <table class="admin-table">--}}
    {{--            <tr>--}}
    {{--                <th>ID</th>--}}
    {{--                <th>UID</th>--}}
    {{--                <th>Rolle</th>--}}
    {{--                <th>Username</th>--}}
    {{--                <th>Aktive</th>--}}
    {{--                <th></th>--}}
    {{--                <!-- Fügen Sie hier zusätzliche Spalten für andere Benutzerinformationen hinzu -->--}}
    {{--            </tr>--}}

    {{--            @foreach ($viewData['rfid'] as $rfid)--}}
    {{--                <tr>--}}
    {{--                    <td>{{ $rfid->id }}</td>--}}
    {{--                    <td>{{ Str::limit($rfid->tag_uid, 10) }}</td>--}}
    {{--                    <td>{{ Str::limit($rfid->role, 10) }}</td>--}}
    {{--                    <td>{{ Str::limit($rfid->tag_active, 10) }}</td>--}}
    {{--                    <td>{{ Str::limit($rfid->user->username, 10) }}</td>--}}

    {{--                    <td><a href="rfids/{{ $rfid->id }}/edit">Edit</a></td>--}}
    {{--                    <!-- Fügen Sie hier zusätzliche Zellen für andere Benutzerinformationen hinzu -->--}}
    {{--                </tr>--}}
    {{--            @endforeach--}}
    {{--        </table>--}}
    {{--    </div>--}}
    <div class="admin-dash-user-table">
        @livewire('rfid-table')
    </div>
@endsection
