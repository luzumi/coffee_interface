@extends('layouts.app')

@section('content')
    <h1>Willkommen, {{ $viewData['user']->username }}!</h1>
    <p>Ihr Channel-URL lautet: {{ $viewData['channel_url'] }}</p>
    <p>Ihr User_id lautet: {{ $viewData['user']->id }}</p>
@endsection

{{--@section('scripts')--}}
{{--    @if(session()->has('webhook_data'))--}}
{{--        <script>--}}
{{--            // Die Daten in der Session sind vorhanden, fügen Sie den Namen und den Channel-URL in die Menüseite ein--}}
{{--            var name = "{{ session()->get('webhook_data.name') }}";--}}
{{--            var channelUrl = "{{ session()->get('webhook_data.channel_url') }}";--}}
{{--            $("h1").text("Willkommen, " + name + "!");--}}
{{--            $("p").text("Ihr Channel-URL lautet: " + channelUrl);--}}

{{--            // Löschen Sie die Daten aus der Session, damit sie nicht erneut angezeigt werden--}}
{{--            sessionStorage.removeItem('webhook_data');--}}
{{--        </script>--}}
{{--    @endif--}}
{{--@endsection--}}
