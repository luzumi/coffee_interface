<div>
    <table class="admin-table">
        <tr>
            <th wire:click="sortBy('id')">ID</th>
            <th wire:click="sortBy('coffee_name')">Titel</th>
            <th wire:click="sortBy('credit_cost')">Credits</th>
            <th wire:click="sortBy('coffee_code')">Code</th>
            <th wire:click="sortBy('coffee_description')">Beschreibung</th>
            <th wire:click="sortBy('coffee_image')">Image</th>
            <th></th>
        </tr>
        @foreach ($cats as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ Str::limit($cat->coffee_name, 10) }}</td>
                <td>{{ $cat->credit_cost }}</td>
                <td>{{ $cat->coffee_code }}</td>
                <td>{{ Str::limit($cat->coffee_description, 10) }}</td>
                <td>{{ Str::limit($cat->coffee_image, 6) }}</td>
                <td><a href="cats/{{ $cat->id }}/edit">Edit</a></td>
            </tr>
        @endforeach
    </table>

    {{ $cats->links() }}
</div>
