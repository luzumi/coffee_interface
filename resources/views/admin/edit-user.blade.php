@extends('admin')

@section('dashboard')
    <form method="POST" action="/admin/users/{{ $user['actual']->id }}">
        @csrf
        @method('PUT')

        <div class="admin-form-group">
            <label for="username">Username: </label>
            <input type="text" id="username" name="username" value="{{ $user['actual']->username }}">
        </div>

        <div class="admin-form-group">
            <label for="Vorname">Vorname: </label>
            <input type="text" id="Vorname" name="firstname" value="{{ $user['actual']->firstname }}">
        </div>

        <div class="admin-form-group">
            <label for="lastname">Name: </label>
            <input type="text" id="lastname" name="lastname" value="{{ $user['actual']->lastname }}">
        </div>
<br>
        <div class="admin-form-group">
            <label for="credits">aktuelle Credits: {{ $user['actual']->credits }}</label>
            <div class="admin-inline-form-group">
                <label for="credits">Kredits einzahlen:</label>
                <input type="number" id="credits" name="credits" value="0">
            </div>
        </div>

        <br>

        <label class="admin-label">RFID-Karten</label>
        <table class="admin-table">
            <tr>
                <th >ID</th>
                <th >User-ID</th>
                <th >Tag-UID</th>
                <th >Benutzerrolle</th>
                <th >aktiv</th>
                <!-- Fügen Sie hier zusätzliche Spalten für andere Benutzerinformationen hinzu -->
            </tr>

            @foreach($user['actual']['rfidTag'] as $rfidTag)
                <tr>
                    <td >{{ $rfidTag->id }}</td>
                    <td >{{ $rfidTag->user_id }}</td>
                    <td >{{ $rfidTag->tag_uid }}</td>
                    <td >{{ $rfidTag->role }}</td>
                    <td >{{ $rfidTag->tag_active }}</td>
                    <!-- Fügen Sie hier zusätzliche Zellen für andere Benutzerinformationen hinzu -->
                </tr>
            @endforeach
        </table>

<br>
        <!-- Fügen Sie hier weitere Felder hinzu, wenn Sie weitere Benutzerinformationen bearbeiten möchten -->

        <button class="btn" type="submit">Update</button>
    </form>

@endsection
