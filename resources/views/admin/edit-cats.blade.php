@extends('admin.admin')

@section('dashboard')
    <form method="POST" action="/admin/cats/{{ $viewData['cats']->id }}">
        @csrf
        @method('PUT')

        <div class="admin-form-group">
            <label for="title">Titel: </label>
            <input type="text" id="title" name="title" value="{{ $viewData['cats']->coffee_name }}">
        </div>

        <div class="admin-form-group">
            <label for="cost">Preis: </label>
            <input type="text" id="cost" name="cost" value="{{ $viewData['cats']->credit_cost }}">
        </div>

        <div class="admin-form-group">
            <label for="code">Code: </label>
            <button type="button" onclick="window.location='{{ route('admin.help-display') }}'" class="btn">
                Codes
            </button>
            <input type="text" id="code" name="code" value="{{ $viewData['cats']->coffee_code }}">
        </div>

        <div class="admin-form-group">
            <label for="description">Beschreibung: </label>
            <input type="text" id="description" name="description" value="{{ $viewData['cats']->coffee_description }}">
        </div>

        <div class="admin-form-group">
            <label for="image">Image: </label>
            <input type="text" id="image" name="image" value="{{ $viewData['cats']->coffee_image }}" readonly>
        </div>
        <br>


        <br>



        <br>
        <!-- Fügen Sie hier weitere Felder hinzu, wenn Sie weitere Benutzerinformationen bearbeiten möchten -->

        <button class="btn" type="submit">Update</button>
    </form>

@endsection
