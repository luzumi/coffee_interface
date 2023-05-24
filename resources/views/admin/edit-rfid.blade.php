@extends('admin.admin')

@section('dashboard')
    <label class="admin-label">RFID-Karte (ID = {{ $rfid['actual']->id }})</label>
    <table class="admin-table" id="rfid-table">
        <tr>
            <th>User-ID</th>
            <th>Tag-UID</th>
            <th>Benutzer</th>
            <th>Rolle</th>
            <th>aktiv</th>
            <!-- Fügen Sie hier zusätzliche Spalten für andere Benutzerinformationen hinzu -->
        </tr>


        <tr>
            <td>{{ $rfid['actual']->user_id }}</td>
            <td>{{ $rfid['actual']->tag_uid }}</td>
            <td>{{ $rfid['actual']->user->username }}</td>
            <td>{{ $rfid['actual']->role }}</td>
            <td>{{ $rfid['actual']->tag_active ? 'Ja' : 'Nein' }}</td>
            <!-- Fügen Sie hier zusätzliche Zellen für andere Benutzerinformationen hinzu -->
        </tr>

    </table>

    <br>
    <label class="admin-label">Edit:</label>

    <form method="POST" action="/admin/rfids/{{ $rfid['actual']->id }}" id="oldUserName">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $rfid['actual']->user->username }}" id="oldUserName" name="oldUserName">

        <div class="admin-form-group" id="existing-user-fields">
            <label for="existing-username">RFID-Karte -> User zuweisen: </label>
            <input type="text" id="existing-username" name="username" value="{{ $rfid['actual']->user->username }}" readonly>
            <div class="admin-custom-select-wrapper">
                <label for="user-select"></label><select id="user-select" class="admin-custom-select">
                    <option value="new">Add New User</option>
                    @foreach($rfid['allUsers'] as $user)
                        <option value="{{ $user->username }}"
                            {{ $rfid['actual']->user->username == $user->username ? 'selected' : '' }}>
                            {{ $user->username }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div id="new-user-fields" style="display: none;">
            <div class="admin-form-group">
                <label for="new-username">New Username: </label>
                <input type="text" id="new-username" name="new_username" placeholder="Username" value="">
            </div>
            <div class="admin-form-group">
                <label for="new-firstname">New First Name: </label>
                <input type="text" id="new-firstname" name="firstname">
            </div>
            <div class="admin-form-group">
                <label for="new-lastname">New Last Name: </label>
                <input type="text" id="new-lastname" name="lastname">
            </div>
            <div class="admin-form-group">
                <label for="new-credits">New Credits: </label>
                <input type="number" id="new-credits" name="credits">
            </div>
        </div>


        <label for="name">Name: </label>
        <label for="name"> "{{ $rfid['actual']->user->firstname }} {{ $rfid['actual']->user->lastname }}"</label>
        <label for="role"></label><select id="role" name="role">
            @foreach($rfid['roles'] as $role)
                <option value="{{ $role }}"
                    {{ $rfid['actual']->role == $role ? 'selected' : '' }}>
                    {{ $role }}
                </option>
            @endforeach
        </select>

        <div class="admin-form-group">
            <label for="tag_active">Aktive: </label>
            <input type="checkbox" id="tag_active" name="tag_active" value="1"
                {{ $rfid['actual']->tag_active ? 'checked' : '' }}>
        </div>
        <br>

        <button class="btn" type="submit">Update</button>
    </form>
@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user-select').change(function() {
                var selectedUser = $(this).val();

                if (selectedUser === 'new') {
                    $('#new-user-fields').show();
                    $('#existing-user-fields').hide();
                } else {
                    // Setzen Sie den Wert des 'existing-username'-Feldes auf den ausgewählten Benutzernamen
                    $('#existing-username').val(selectedUser);
                    $('#new-user-fields').hide();
                    $('#existing-user-fields').show();
                }
            });
        });
    </script>
@endsection
