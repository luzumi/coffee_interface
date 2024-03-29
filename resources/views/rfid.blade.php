@extends('layouts.app')

@section('content')


    <div class="title_app">
        <h1>Get me Coffee - </h1>

        <h1 class="title_welcome"> &nbsp;Help - RFID</h1>
    </div>
    <ol class="help-text">
        <hr>
        <li ><strong>Einloggen:</strong> Halten Sie Ihre RFID-Karte an das Lesegerät, um sich einzuloggen.</li>
        <hr>
        <li><strong>Guthaben aufladen:</strong>  Ihr Guthaben können Sie bei Alexander Seedorf aufladen.</li>
        <hr>
        <li><strong>Neue RFID-Karte registrieren:</strong>
            <ul>
                <li>Loggen Sie sich mit Ihrer RFID-Karte ein.</li>
                <li>Verwenden Sie einen inkompatiblen Kartentyp, wird Ihnen dieses angezeigt.</li>
                <li>Ihre Karte wird gelesen und ins System eingetragen.</li>
                <li>Ihr Code wird nun angezeigt.</li>
                <li>Merken Sie sich den Code und wenden Sie sich bei Alexander Seedorf.</li>
                <li>Dort können Sie dann Ihre Karte aktivieren und Guthaben einzahlen.</li>
                <li>Im Anschluss ist Ihre neue RFID-Karte registriert und einsatzbereit.</li>
                <li>Melden Sie sich erneut an, um endlich in den Genuss eines leckeren Kaffees zu kommen. </li>
            </ul>
        </li>
        <hr>
    </ol>
    <div class="menu-logout">
        <form method="GET" action="{{ route('help') }}">

            <button type="submit" class="btn menu-logout-button">Zurück</button>
        </form>
    </div>
@endsection
