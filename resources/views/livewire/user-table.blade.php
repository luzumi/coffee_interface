<div>
    <label>
        <input type="text" wire:model="search" class="admin-input-field" placeholder="Search Users...">
    </label>
    <table class="admin-table">
        <tr>
            <th wire:click="sortBy('id')">ID</th>
            <th wire:click="sortBy('username')">Username</th>
            <th wire:click="sortBy('firstname')">Vorname</th>
            <th wire:click="sortBy('lastname')">Name</th>
            <th wire:click="sortBy('credits')">Credits</th>
            <th></th>
        </tr>
        @foreach ($users as $user)
            <tr class="{{ $user->active ? '' : 'admin-deactivated' }}">
                <td>{{ $user->id }}</td>
                <td>{{ Str::limit($user->username, 10) }}</td>
                <td>{{ Str::limit($user->firstname, 10) }}</td>
                <td>{{ Str::limit($user->lastname, 10) }}</td>
                <td>{{ $user->credits }}</td>
                <td><a href="users/{{ $user->id }}/edit">Edit</a></td>
            </tr>
        @endforeach
    </table>

    {{ $users->links() }}
</div>
