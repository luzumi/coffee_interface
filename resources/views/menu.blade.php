@extends('layouts.app')

@section('content')
    <h1>Willkommen, {{ $viewData['user']->username }}!</h1>
    <p>Ihr Channel-URL lautet: {{ $viewData['channel_url'] }}</p>
    <p>Ihr User_id lautet: {{ $viewData['user']->id }}</p>


{{--    button zum zurückkehren zur welcome.blade.php--}}
    <form method="POST" action="{{ route('back_to_welcome') }}">
        @csrf
        <button type="submit">Back</button>
    </form>
{{--    Button zum senden eines Webhooks--}}
    <form method="POST" action="{{ route('turn_on') }}">
        @csrf
        <button type="submit">Webhook</button>
    </form>

@endsection

