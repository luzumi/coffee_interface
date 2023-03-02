@extends('layouts.app')

@section('content')
    <h1>Willkommen, {{ $viewData['user']->username }}!</h1>
    <p>Ihr Guthaben beträgt: {{ $viewData['user']->credits }} Credits</p>
    <p>Ihr User_id lautet: {{ $viewData['user']->id }}</p>
    <p>Die letzte Bestellung war am: {{ $viewData['orders']->last()->updated_at}}</p>
    <p>Sie hatten 1 {{ $viewData['orders']->last()->coffee_type}}</p>

    <div class="row">
        @foreach($viewData['varieties'] as $variety)
            <div class="col-md-4">
                <div class="card box">
                    <img src="{{ $variety->coffee_image }}" class="card-img-top" alt="{{ $variety->coffee_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $variety->coffee_name }}</h5>
                        <p class="card-text">{{ $variety->coffee_description }}</p>
                        <p class="card-text box-success">Preis: {{ $variety->credit_cost }} Credits</p>
                        <p class="card-text box-warning">Füllmenge: {{ $variety->coffee_count ?? 'keine Füllmenge angegeben' }}</p>
                        <form method="POST" action="{{ route('new_order', ['type' => $variety->coffee_name]) }}">
                            @csrf
                            <button type="submit" class="edelstahl-button">Bestellen</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@yield('progress')

