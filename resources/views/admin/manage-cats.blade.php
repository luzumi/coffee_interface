@extends('admin.admin')

@section('dashboard')
    {{--    <div class="admin-dash-user-table">--}}
    {{--        <table class="admin-table">--}}
    {{--            <tr>--}}
    {{--                <th>ID</th>--}}
    {{--                <th>Titel</th>--}}
    {{--                <th>Credits</th>--}}
    {{--                <th>Code</th>--}}
    {{--                <th>Beschreibung</th>--}}
    {{--                <th>Image</th>--}}
    {{--                <th></th>--}}
    {{--                <!-- Fügen Sie hier zusätzliche Spalten für andere Benutzerinformationen hinzu -->--}}
    {{--            </tr>--}}

    {{--            @foreach ($viewData['cats'] as $cat)--}}
    {{--                <tr>--}}
    {{--                    <td>{{ $cat->id }}</td>--}}
    {{--                    <td>{{ Str::limit($cat->coffee_name, 10) }}</td>--}}
    {{--                    <td>{{ $cat->credit_cost }}</td>--}}
    {{--                    <td>{{ $cat->coffee_code }}</td>--}}
    {{--                    <td>{{ Str::limit($cat->coffee_description, 10) }}</td>--}}
    {{--                    <td>{{ Str::limit($cat->coffee_image, 6) }}</td>--}}
    {{--                    <td><a href="cats/{{ $cat->id }}/edit">Edit</a></td>--}}
    {{--                    <!-- Fügen Sie hier zusätzliche Zellen für andere Benutzerinformationen hinzu -->--}}
    {{--                </tr>--}}
    {{--            @endforeach--}}
    {{--        </table>--}}
    {{--    </div>--}}
    <div class="admin-dash-user-table">
        @livewire('cat-table')
    </div>
@endsection
