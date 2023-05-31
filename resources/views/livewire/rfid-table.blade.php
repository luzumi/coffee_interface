<div>
    <table class="admin-table">
        <tr>
            <th wire:click="sortBy('id')">ID</th>
            <th wire:click="sortBy('tag_uid')">UID</th>
            <th wire:click="sortBy('role')">Rolle</th>
            <th wire:click="sortBy('tag_active')">Aktive</th>
            <th wire:click="sortBy('username')">Username</th>
            <th></th>
        </tr>
        @foreach ($rfids as $rfid)
            <tr>
                <td>{{ $rfid->id }}</td>
                <td>{{ Str::limit($rfid->tag_uid, 10) }}</td>
                <td>{{ Str::limit($rfid->role, 10) }}</td>
                <td>{{ Str::limit($rfid->tag_active, 10) }}</td>
                <td>{{ Str::limit($rfid->username, 10) }}</td>
                <td><a href="rfids/{{ $rfid->id }}/edit">Edit</a></td>
            </tr>
        @endforeach
    </table>

    {{ $rfids->links() }}
</div>
