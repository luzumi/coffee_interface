@extends('admin.admin')

@section('dashboard')
    <form method="POST" action="/admin/users/{{ $user['actual']->id }}">
        @csrf
        @method('PUT')

        <div class="admin-form-group">
            <label for="username">Username: </label>
            <input class="admin-input-field" type="text" id="username" name="username" value="{{ $user['actual']->username }}">
        </div>

        <div class="admin-form-group">
            <label for="Vorname">Vorname: </label>
            <input class="admin-input-field" type="text" id="Vorname" name="firstname" value="{{ $user['actual']->firstname }}">
        </div>

        <div class="admin-form-group">
            <label for="lastname">Name: </label>
            <input class="admin-input-field" type="text" id="lastname" name="lastname" value="{{ $user['actual']->lastname }}">
        </div>
        <br>
        <div class="admin-form-group">
            <label for="credits">aktuelle Credits: {{ $user['actual']->credits }}</label>
            <div class="admin-inline-form-group">
                <label for="credits">Kredits einzahlen:</label>
                <input class="admin-input-field" type="number" id="credits" name="credits" value="0">
            </div>
        </div>
        <div class="admin-form-group">
            <label for="active">Aktive: </label>
            <input type="checkbox" id="active" name="active" value="1"
                {{ $user['actual']->active ? 'checked' : '' }}>
        </div>
        <br>

        <label class="admin-label">RFID-Karten</label>
        <table class="admin-table">
            <tr>
                <th>ID</th>
                <th>User-ID</th>
                <th>Tag-UID</th>
                <th>Benutzerrolle</th>
                <th>aktiv</th>
                <!-- Fügen Sie hier zusätzliche Spalten für andere Benutzerinformationen hinzu -->
            </tr>

            @foreach($user['actual']['rfidTag'] as $rfidTag)
                <tr>
                    <td>{{ $rfidTag->id }}</td>
                    <td>{{ $rfidTag->user_id }}</td>
                    <td>{{ $rfidTag->tag_uid }}</td>
                    <td>{{ $rfidTag->role }}</td>
                    <td>{{ $rfidTag->tag_active }}</td>
                    <!-- Fügen Sie hier zusätzliche Zellen für andere Benutzerinformationen hinzu -->
                </tr>
            @endforeach
        </table>

        <br>
        <!-- Fügen Sie hier weitere Felder hinzu, wenn Sie weitere Benutzerinformationen bearbeiten möchten -->

        <button class="btn" type="submit">Update</button>
        <button type="button" onclick="confirmDelete('{{ route('admin.users.id-delete', $user['actual']->id) }}',
                'Bist du sicher, dass du diesen User löschen möchtest?')" class="btn">
            Löschen
        </button>
    </form>

@endsection

@section('scripts')
    <script>
        function confirmDelete(url, message) {
            if (confirm(message)) {
                window.location = url;
            }
        }
    </script>
@endsection
